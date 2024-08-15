<div id="faq" class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto divide-y-2 divide-gray-200">
            <h2 class="text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">Frequently asked questions</h2>
            <dl class="mt-6 space-y-6 divide-y divide-gray-200">
                @foreach($faqs as $faq)
                    <div class="pt-6">
                        <dt class="text-lg">
                            <button type="button" class="text-left w-full flex justify-between items-start text-gray-400" data-toggle="collapse">
                                <span class="font-medium text-gray-900"> {{ $faq->name }} </span>
                                <span class="ml-6 h-7 flex items-center">
                                    <svg data-toggle="icon" class="rotate-0 h-6 w-6 transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </dt>
                        <dd class="mt-2 pr-12" data-toggle="content" style="display: none;">
                            <p class="text-base text-gray-500">{{ $faq->meta['description'] }}</p>
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</div>

<script>
    const triggers = document.querySelectorAll('[data-toggle="collapse"]')
    const contents = document.querySelectorAll('[data-toggle="content"]')
    const icons = document.querySelectorAll('[data-toggle="icon"]')

    for (let i = 0; i < triggers.length; i++) {
        triggers[i].addEventListener("click", () => {
            const isOpen = contents[i].style.display == "block"
            contents[i].style.display = contents[i].style.display == "block" ? "none" : "block"

            if (isOpen) {
                icons[i].classList.replace('rotate-180','rotate-0')
            } else {
                icons[i].classList.replace('rotate-0','rotate-180')
            }
        })
    }
</script>
