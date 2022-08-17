<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <title>Editor</title>
</head>
<body class="w-screen h-screen flex flex-row ">
  <div class="h-screen w-[20%] bg-gray-300">
    <p>dfg</p>
  </div>



  <iframe id="frame" onload="run()" class="h-screen w-[80%]" src="/" ></iframe>
  
   <script>
    const run = () => {
      document.getElementById('frame').contentWindow.document.querySelectorAll('p, h1, h2, h3, img').forEach(p => {
        p.setAttribute('contenteditable', true);
        p.classList.add('hover:outline','outline-offset-2','outline-2')

        

        if (p.tagName == "P") {
          let P = document.createElement('P');
          P.innerHTML = 'ADD MORE'
          p.parentNode.insertBefore(P, p.nextSibling)

          P.onclick = () => {
            P.setAttribute('contenteditable', true)
            P.classList.add('hover:outline','outline-offset-2','outline-2')
            P.innerHTML = 'Edit me'
          }
        }
      })
    }
   </script>
  
</body>
</html>