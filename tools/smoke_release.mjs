// Operator-run, read-only checks. No form submissions or live provider calls.
import assert from 'node:assert/strict'
import { pathToFileURL } from 'node:url'

export async function smokeRelease({ website, api, portal }, fetcher = fetch) {
  const results = []
  for (const value of [website, api, portal]) {
    const url = new URL(value)
    assert(['http:', 'https:'].includes(url.protocol) && !url.username && !url.password, 'Use HTTP(S) origins without credentials')
    assert(url.pathname === '/' && !url.search && !url.hash, 'Provide origins without paths')
  }
  async function check(origin, path, statuses, type) {
    const response = await fetcher(new URL(path, origin), { redirect: 'manual', signal: AbortSignal.timeout(10000) })
    assert(statuses.includes(response.status), `${path}: unexpected HTTP ${response.status}`)
    if (type) assert(response.headers.get('content-type')?.includes(type), `${path}: incorrect content type`)
    results.push({ origin: new URL(origin).origin, path, status: response.status })
    return response
  }
  await check(website, '/health/live', [200])
  const html = await (await check(website, '/about', [200], 'text/html')).text()
  const asset = html.match(/<script[^>]*\bsrc="([^"]+)"/i)?.[1]
  assert(asset, 'Vue entry script is missing')
  const script = new URL(asset, website)
  assert(script.origin === new URL(website).origin, 'Vue script must use the website origin')
  await check(website, script.pathname, [200], 'javascript')
  await check(website, '/assets/__missing-release-check__.js', [404])
  for (const origin of [website, api]) {
    const data = await (await check(origin, '/api/v1/clubs', [200], 'application/json')).json()
    assert(Array.isArray(data.data), 'Clubs response does not match the public contract')
    await check(origin, '/api/v1/__missing-release-check__', [404], 'application/json')
  }
  await check(api, '/health/ready', [200], 'application/json')
  await check(api, '/dashboard', [404])
  const dashboard = await check(portal, '/dashboard', [302, 303])
  const location = dashboard.headers.get('location')
  assert(location && new URL(location, portal).origin === new URL(portal).origin, 'Dashboard must start login on the portal origin')
  const resources = await (await check(api, '/api/v1/resources', [200], 'application/json')).json()
  if (resources.data?.length) {
    const id = encodeURIComponent(resources.data[0].id)
    const access = await (await check(api, `/api/v1/resources/${id}/access`, [200], 'application/json')).json()
    const file = new URL(access.data.url)
    assert(file.origin === new URL(api).origin, 'Download must use the API origin')
    const response = await check(api, file.pathname + file.search, [200])
    assert(response.headers.get('content-disposition')?.includes('attachment'), 'Expected a document attachment')
    await response.arrayBuffer()
  } else {
    results.push({ skipped: 'No published resource available to verify a real download' })
  }
  return results
}

if (process.argv[1] && import.meta.url === pathToFileURL(process.argv[1]).href) {
  try {
    const results = await smokeRelease({ website: process.env.PUBLIC_SITE_ORIGIN || 'https://www.bulsca.co.uk', api: process.env.PUBLIC_API_ORIGIN || 'https://api.bulsca.co.uk', portal: process.env.PORTAL_ORIGIN || 'https://portal.bulsca.co.uk' })
    console.log(JSON.stringify({ passed: true, results }, null, 2))
  } catch (error) {
    console.error(error.message)
    process.exitCode = 1
  }
}
