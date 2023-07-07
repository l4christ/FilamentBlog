<?php
/** @var $posts illuminate\Pagination\LengthAwarePaginator */
?>

<x-app-layout meta-description="The Emmanuel's personal Blog">
    <!-- Posts Section -->
    <div class="container max-w-3xl mx-auto py-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Latest Posts --}}
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                    <x-post-item :post="$latestPost" />
                </h2>
            </div>

            {{-- Popular 3 post --}}
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                    Popular Posts
                </h2>
            </div>
        </div>

        {{-- Recommended Post --}}
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                Recommended Post
            </h2>
        </div>

        {{-- Latest Category --}}
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                Recent Categories
            </h2>
        </div>

    </div>
    
</x-app-layout>