<div class="flex items-center justify-between mt-8 mb-4">
    <div class="flex items-center space-x-4">
        <div class="flex items-center" wire:click="react('thumbs_up')">
            <i class="text-gray-900 fa-regular fa-thumbs-up {{ $userReaction && $userReaction->type === 'thumbs_up' ? 'text-blue-500' : '' }}"></i>
            <span class="ml-1 text-gray-900">{{ $thumbsUpCount }}</span>
        </div>
        <div class="flex items-center" wire:click="react('thumbs_down')">
            <i class="text-gray-900 fa-regular fa-thumbs-down {{ $userReaction && $userReaction->type === 'thumbs_down' ? 'text-blue-500' : '' }}"></i>
            <span class="ml-1 text-gray-900">{{ $thumbsDownCount }}</span>
        </div>
        <div class="flex items-center">
            <i class="text-gray-900 fa-regular fa-bookmark"></i>
        </div>
    </div>
</div>