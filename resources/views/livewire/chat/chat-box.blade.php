<div>

    {{-- header --}}
    <header class="w-full sticky inset-x-0 flex pb-[5px] pt-[5px] top-0 z-10 bg-white border-b">

        <div class="flex w-full items-center px-2 lg:px-4 gap-2 md:gap-5">

            <a href="#" class="shrink-0 lg:hidden">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                  </svg>

            </a>

            {{-- avatar --}}

            <div class="shrink-0">
                <x-avatar class="h-9 w-9 lg:w-11 lg:h-11" />
            </div>

            <h6 class="font-bold truncate">{{ fake()->name() }}</h6>

        </div>

    </header>

    {{-- body --}}
    <main class="flex flex-col gap-3 p-2.5 overflow-y-auto flex-grow overscroll-contain overflow-x-hidden w-full my-auto">

        <div @class([
            'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2'
        ])>

        {{-- avatar --}}

        <div @class(['shrink-0'])>

            <x-avatar />

            {{-- message body --}}

            <div @class([
                'flex flex-wrap text-[15px] rounded-xl p-2.5 flex flex-col text-black bg-[#f6f6f8fb]',
                'rounded-bl-none border border-gray-200/40'=>false,
                'rounded-br-none bg-blue-500/80  text-white'=>true
            ])>

            <p class="whitespace-normal truncate text-sm md:text-base tracking-wide lg:tracking-normal">
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
            </p>

            <div class="ml-auto flex gap-2">

                <p @class([
                    'text-xs',
                    'text-gray-500'=>false,
                    'text-white'=>true
                ])>

                5:25 am

                </p>

                {{-- messages status, only show if message belongs auth --}}

                <div>

                    {{-- double ticks --}}
                    <span @class('text-gray-500')>

                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                            <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
                        </svg>

                    </span>

                    {{-- single ticks --}}
                    {{-- <span @class('text-gray-500')>

                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                        </svg>

                    </span> --}}

                </div>



            </div>

            </div>

        </div>

        </div>

    </main>

    {{-- footer --}}

</div>
