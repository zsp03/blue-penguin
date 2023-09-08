<x-app-layout>
    <div class="bg-[url('/public/assets/images/library-with-books.jpg')] bg-cover min-h-screen">
        <div class="min-h-screen w-full backdrop-brightness-50">
            <div class="min-w-screen flex-col m-auto ml-48 mr-48">
                <div class="pt-24">
                    <h2 class="flex-col flex-wrap text-center text-4xl font-bold text-white">
                        Search for journals, articles, and community service research paper
                    </h2>
                </div>
            </div>
            <div>
                <div class="min-w-screen flex-col m-auto ml-48 mr-48 mt-24">
                    <form>
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari Jurnal, Penelitian, Pengabdian..." required>
                            <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex justify-center underline mt-36 gap-48 text-white text-xl font-bold flex-wrap">
                <div>
                    <h3>
                        Jurnal
                    </h3>
                </div>
                <div>
                    <h3>
                        Prosiding
                    </h3>
                </div>
                <div>
                    <h3>
                        Penelitian
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div >

    </div>
</x-app-layout>
