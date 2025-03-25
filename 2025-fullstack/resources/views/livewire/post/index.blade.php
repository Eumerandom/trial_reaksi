<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div wire:poll.2000ms class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"> -->
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <!-- <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"> -->
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-7">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-7">
                            Content
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($posts as $key => $post)
                        <!-- <tr class="bg-white dark:bg-gray-800"> -->
                        <tr class="bg-white">
                            <!-- <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitecpace-nowrap dark:text-white"> -->
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitecpace-nowrap">
                                {{ $post->title }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $post->content }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>