<div id="features" class="bg-white">

    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8">

        <div>

            <h2 class="text-base font-semibold text-indigo-600 uppercase tracking-wide">BE FULLY TRANSPARENT</h2>

            <p class="mt-2 text-3xl font-extrabold text-gray-900">Keep On Track, Stay Connected.</p>

            <p class="mt-4 text-lg text-gray-500">Effortlessly manage every aspect with a single solution designed for agency-client management or simply to keep yourself organized.</p>

        </div>

        <div class="mt-12 lg:mt-0 lg:col-span-2">

            <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">

                @foreach($features as $feature)

                    <div class="relative">

                        <dt>

                            <!-- Heroicon name: outline/check -->

                            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">

                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />

                            </svg>

                            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">{{ $feature->name }}</p>

                        </dt>

                        <dd class="mt-2 ml-9 text-base text-gray-500">{{ $feature->meta['description'] }}</dd>

                    </div>

                @endforeach

            </dl>

        </div>

    </div>

</div>

