<div id="pricing" class="bg-gray-900">

    <div class="pt-12 sm:pt-16 lg:pt-24">

        <div class="max-w-7xl mx-auto text-center px-4 sm:px-6 lg:px-8">

            <div class="max-w-3xl mx-auto space-y-2 lg:max-w-none">

                <h2 class="text-lg leading-6 font-semibold text-gray-300 uppercase tracking-wider">Pricing</h2>

                <p class="text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl">The perfect price, tailored for you.</p>

                <p class="text-xl text-gray-300">No matter who you are, we've got the right solution at the right price.</p>

            </div>

        </div>

    </div>

<div class="mt-8 pb-12 bg-gray-50 sm:mt-12 sm:pb-16 lg:mt-16 lg:pb-24">
    <div class="relative">
        <div class="absolute inset-0 h-3/4 bg-gray-900"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto lg:max-w-5xl lg:grid lg:grid-cols-2 lg:gap-5">
                @foreach ($plans->take(2) as $plan)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-8 bg-white sm:p-10 sm:pb-6">
                            <div>
                                <h3 class="inline-flex px-4 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-indigo-100 text-indigo-600" id="tier-standard">{{ $plan->name }}</h3>
                            </div>
                            <div class="mt-4 flex items-baseline text-6xl font-extrabold">
                                ${{ $plan->meta['monthly_price'] }}
                                <span class="ml-1 text-2xl font-medium text-gray-500"> /mo </span>
                            </div>
                            <p class="mt-5 text-lg text-gray-500">{{ $plan->meta['short_description'] }}</p>
                        </div>
                        <div class="flex-1 flex flex-col justify-between px-6 pt-6 pb-8 bg-gray-50 space-y-6 sm:p-10 sm:pt-6">
                            <ul role="list" class="space-y-4">
                                @foreach($plan->meta['features'] as $feature)
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">{{ $feature }}</p>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="rounded-md shadow">
                                <a href="/register" class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900" aria-describedby="tier-standard"> Get started </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
