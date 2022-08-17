<div id="sliver" class="fixed bottom-0 left-0 w-screen h-10 bg-green-500 ease-in-out text-center transition flex items-center justify-center text-white ">
  {{ $slot }}
  <script>
    let s = document.getElementById('sliver')
    setTimeout(function() {
      s.classList.add("translate-y-11")

    }, 2000)
  </script>
</div>