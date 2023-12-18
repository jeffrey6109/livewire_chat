<div
x-data="{height:0,conversationElement:document.getElementById('conversation')}"
x-init  = "
            height = conversationElement.scrollHeight;
            $nextTick(() => conversationElement.scrollTop = height)
            "

@scroll-bottom.window = " $nextTick(() => conversationElement.scrollTop = height)"

class="w-full overflow-hidden">

    <div class="border-b flex flex-col overflow-y-scroll grow h-full">

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

                <h6 class="font-bold truncate">{{ $selectedConversation->getReceiver()->email }}</h6>

            </div>

        </header>

        {{-- body --}}
        <main id="conversation" class="flex flex-col gap-3 p-2.5 overflow-y-auto flex-grow overscroll-contain overflow-x-hidden w-full my-auto">

            @if($loadedMessages)

            @php
                $previousMessage= null;
            @endphp

            @foreach ($loadedMessages as $key=> $message)

            {{-- keep track of the previous messages --}}
            @if ($key>0)

                @php
                    $previousMessage= $loadedMessages->get($key-1)
                @endphp

            @endif

            <div @class([
                'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2',
                'ml-auto' => $message->sender_id === auth()->id(),
            ])>
            {{-- avatar --}}

            <div @class([
                'shrink-0',
                'invisible'=>$previousMessage?->sender_id==$message->sender_id,
                'hidden'=>$message->sender_id === auth()->id()
                ])>

                <x-avatar />

            </div>

                {{-- message body --}}

                <div @class([
                    'flex flex-wrap text-[15px]  rounded-xl p-2.5 flex flex-col text-black bg-[#f6f6f8fb]',
                    'rounded-bl-none border border-gray-200/40' => !($message->sender_id === auth()->id()),
                    'rounded-br-none bg-blue-500/80  text-white' => $message->sender_id === auth()->id()
                ])>

                <p class="whitespace-normal truncate text-sm md:text-base tracking-wide lg:tracking-normal md:max-w-md lg:max-w-lg sm:max-w-sm max-w-xs">
                    {{$message->body}}
                </p>

                <div class="ml-auto flex gap-2">

                    <p @class([
                        'text-xs',
                        'text-gray-500' => !($message->sender_id === auth()->id()),
                        'text-white' => $message->sender_id === auth()->id()
                    ])>

                    {{ $message->created_at->format('g:i a') }}

                    </p>

                    {{-- messages status, only show if message belongs auth --}}

                    @if ($message->sender_id === auth()->id())

                        <div>

                            @if ($message->isRead())

                                {{-- double ticks --}}
                                <span @class('text-gray-200')>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                                        <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
                                    </svg>

                                </span>

                            @else

                                {{-- single ticks --}}
                                <span @class('text-gray-500')>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                    </svg>

                                </span>

                            @endif

                        </div>

                    @endif

                </div>

                </div>

            </div>

            @endforeach

            @endif

        </main>

        {{-- send message --}}
        <footer class="shrink-0 z-10 bg-white inset-x-0">

            <div class="p-2 border-t">

                <form
                wire:submit="sendMessage"
                method="POST" autocapitalize="off">
                   @csrf

                   <input type="hidden" autocomplete="false" style="display:none">

                   <div class="grid grid-cols-12">
                        <input
                               {{-- x-model="body" --}}
                               wire:model="body"
                               type="text"
                               autocomplete="off"
                               autofocus
                               placeholder="write your message here"
                               maxlength="1700"
                               class="col-span-10 bg-gray-100 border-0 outline-0 focus:border-0 focus:ring-0 hover:ring-0 rounded-lg  focus:outline-none"
                        >

                        <button class="col-span-2" type='submit'>Send</button>

                   </div>

               </form>

                @error('body')

                    <p> {{ $message }} </p>

                @enderror

            </div>

        </footer>

    </div>

</div>
