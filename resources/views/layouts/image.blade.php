<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title')</title>
    <meta name="token" content="{{ csrf_token() }}"/>

    <link
        rel="stylesheet"
        href="dropzone.css"
        type="text/css"
    />

    @vite('resources/css/app.css')
</head>
<body>

<div
    class="bg-purple-900 absolute top-0 left-0 bg-gradient-to-b from-gray-900 via-gray-900 to-purple-800 bottom-0 leading-5 h-full w-full overflow-hidden">

</div>
<div
    class="relative   min-h-screen  sm:flex sm:flex-row  justify-center bg-transparent rounded-3xl shadow-xl">
    <div class="flex justify-center self-center  z-10 ">
        <div class="p-12 bg-white mx-auto rounded-3xl w-2/3 my-10 ">
            <div class="mb-7">
                @yield('content')
            </div>

            <div class="mt-7 text-center text-gray-300 text-xs">
                <p>
                	<span>
                Copyright ©
                @if (date('Y') > 2022)
                            2022-{{ date('Y') }}
                        @else
                            2022
                        @endif
                <a href="https://github.com/johnnymast" rel="" target="_blank" title="Visit my github page"
                   class="text-purple-500 hover:text-purple-600 ">Johnny Mast</a></span>
                </p>
                <p>
					<span>
                Theme Copyright © 2021-{{ date('Y') }}
                <a href="https://codepen.io/uidesignhub" rel="" target="_blank" title="Codepen aji"
                   class="text-purple-500 hover:text-purple-600 ">AJI</a></span>
                </p>
            </div>

        </div>
    </div>
</div>

<footer class="bg-transparent absolute w-full bottom-0 left-0 z-30">
    <div class="container p-5 mx-auto  flex items-center justify-between ">
        <div class="flex mr-auto">
            <a href="https://github.com/johnnymast"  target="_blank" title="Visit my github profile"
               class="text-center text-gray-700 focus:outline-none"><img
                    src="/GitHub-Mark-64px.png" alt="aji"
                    class="object-cover mx-auto w-8 h-8 rounded-full w-10 h-10">
                <p class="text-xl">Johnny<strong>Mast</strong></p></a>
        </div>

    </div>
</footer>

<svg class="absolute bottom-0 left-0 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#fff" fill-opacity="1"
          d="M0,0L40,42.7C80,85,160,171,240,197.3C320,224,400,192,480,154.7C560,117,640,75,720,74.7C800,75,880,117,960,154.7C1040,192,1120,224,1200,213.3C1280,203,1360,149,1400,122.7L1440,96L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path>
</svg>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>

@vite('resources/js/app.js')
</body>
</html>
