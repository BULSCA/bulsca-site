import { test } from 'node:test'
import assert from 'node:assert/strict'
import { spawnSync } from 'node:child_process'
import { fileURLToPath } from 'node:url'
import { smokeRelease } from './smoke_release.mjs'

const origins = { website: 'https://www.example.test', api: 'https://api.example.test', portal: 'https://portal.example.test' }
function fixture(overrides = {}) {
  return async (input, options) => {
    assert.equal(options.redirect, 'manual')
    assert.equal(options.method, undefined)
    const url = new URL(input)
    if (url.pathname in overrides) return overrides[url.pathname](url)
    if (url.pathname === '/about') return new Response('<script type="module" src="/assets/app.js"></script>', { headers: { 'content-type': 'text/html' } })
    if (url.pathname === '/assets/app.js') return new Response('/* fixture */', { headers: { 'content-type': 'application/javascript' } })
    if (url.pathname.includes('__missing-release-check__')) return Response.json({}, { status: 404 })
    if (url.pathname === '/api/v1/clubs') return Response.json({ data: [] })
    if (url.pathname === '/api/v1/resources') return Response.json({ data: [{ id: 'fixture-document' }] })
    if (url.pathname.endsWith('/access')) return Response.json({ data: { url: origins.api + '/api/v1/resources/fixture-document/file' } })
    if (url.pathname.endsWith('/file')) return new Response('document bytes', { headers: { 'content-disposition': 'attachment; filename=test.txt' } })
    if (url.pathname === '/dashboard') return new Response(null, { status: url.origin === origins.api ? 404 : 302, headers: { location: origins.portal + '/login' } })
    return Response.json({ status: 'ok' })
  }
}
test('smoke checks validate same-origin API, portal and real download without writes', async () => {
  const results = await smokeRelease(origins, fixture())
  assert(results.some((result) => result.path?.endsWith('/file')))
})
test('a readiness failure fails acceptance', async () => {
  await assert.rejects(smokeRelease(origins, fixture({ '/health/ready': () => Response.json({}, { status: 503 }) })), /503/)
})
test('an asset fallback to HTML fails acceptance', async () => {
  await assert.rejects(smokeRelease(origins, fixture({ '/assets/__missing-release-check__.js': () => new Response('<html>') })), /unexpected HTTP 200/)
})
test('a portal download origin fails acceptance', async () => {
  await assert.rejects(smokeRelease(origins, fixture({ '/api/v1/resources/fixture-document/access': () => Response.json({ data: { url: origins.portal + '/file' } }) })), /API origin/)
})
test('an empty public resource list explicitly reports skipped download verification', async () => {
  const results = await smokeRelease(origins, fixture({ '/api/v1/resources': () => Response.json({ data: [] }) }))
  assert(results.some((result) => result.skipped))
})
test('the command-line entrypoint runs and rejects invalid origins before network access', () => {
  const result = spawnSync(process.execPath, [fileURLToPath(new URL('./smoke_release.mjs', import.meta.url))], { env: { ...process.env, PUBLIC_SITE_ORIGIN: 'file:///tmp' }, encoding: 'utf8', timeout: 5000 })
  assert.equal(result.status, 1)
  assert.match(result.stderr, /Use HTTP\(S\) origins/)
})
