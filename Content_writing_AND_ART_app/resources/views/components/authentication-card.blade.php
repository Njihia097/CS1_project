<div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
<div class="flex items-center justify-center">
            <!-- SVG Logo with Application Name -->
            <svg class="h-10 mr-2 sm:h-10 md:h-12 lg:h-12 xl:h-16" viewBox="0 0 512 512">
                <!-- Background Rectangle -->
                <rect width="512" height="512" x="0" y="0" rx="80" fill="url(#linearGradient-iconWithBackground)" stroke="#000000" stroke-width="0" stroke-opacity="100%" paint-order="stroke"/>

                <!-- Gradient Definition -->
                <defs>
                    <linearGradient id="linearGradient-iconWithBackground" gradientUnits="userSpaceOnUse" gradientTransform="rotate(0)" style="transform-origin:center center">
                        <stop stop-color="#1e13be"/>
                        <stop offset="1" stop-color="#000000"/>
                    </linearGradient>
                </defs>

                <!-- SVG Logo Content -->
                <svg xmlns="http://www.w3.org/2000/svg" width="340" height="340" viewBox="0 0 64 64" x="86" y="86">
                    <!-- Logo Path -->
                    <path fill="#ffffff" d="M55.339 30.79c-2.519-1.382-11.341-4.241-18.681-6.38l5.328-5.503l.578.599l1.273-1.314l-.578-.6l3.684-3.807l-.705-.73l3.684-3.805L46.778 6l-3.685 3.806l-.709-.73l-3.687 3.806l-1.38-1.424l-8.511 8.802l1.073 1.113l7.221-7.466l.316.3l-7.795 8.051c-7.035-3.226-9.701.335-13.346 5.255c-1.995 2.692-4.479 6.044-8.344 9.308c-1.264 1.065-2.559 2.899-2.4 4.853c.078.97.574 2.344 2.356 3.55l-3.794 7.037L2 54.427l1.036 1.071l2.103-2.171l4.873-2.797c.909 1.213 2.311 2.074 3.742 2.215c3.441.344 6.357 1.625 9.178 2.864C25.729 56.839 28.37 58 31.128 58c3.637 0 6.477-.493 9.482-1.016c3.901-.677 8.323-1.444 15.791-1.444c2.778 0 4.736-2.27 5.372-6.224c1.123-6.956-2.065-16.132-6.434-18.526M26.007 41.379c-.959-.442-1.871-.861-2.623-1.137c-.055-.02-.116-.037-.171-.057c.432-.677 1.31-1.824 3.042-3.444c-.131 1.918-.21 3.691-.248 4.638m16.378-30.508l2.822 2.914l-2.816 2.908l-2.822-2.914l2.816-2.908m-4.091 4.225l2.822 2.914l-20.901 21.588c-2.745-.175-6.041.573-8.878 3.343l26.957-27.845M9.236 38.367c4.085-3.368 6.606-6.871 8.664-9.647c3.544-4.783 5.396-7.568 10.644-5.348l-18.53 19.141c-.917-.541-3.09-2.24-.778-4.146M5.965 51.405l2.959-5.508l.255.263a4.758 4.758 0 0 0 .161 3.206l-3.375 2.039m54.381-2.683c-.271 1.688-2.309 3.986-4.612 3.986c-7.643 0-11.49 1.126-15.48 1.772c-7.724 1.249-13.457-.34-15.953-1.931c-6.256-3.986-9.667-1.93-12.542-4.145c-.925-.713-.842-2.455.063-3.544c4-4.802 9.208-3.997 10.898-3.195c4.865 2.31 9.289 2.65 10.472 2.392c1.185-.242 2.233-.886 3.051-1.693c-.93.683-2.016 1.133-3.124 1.192c-1.105.077-4.287-.916-4.826-1.147c-.195-.957-.509-2.663-.538-3.914c1.994 2.033 4.186 2.549 4.186 2.549l-4.265-5.624s6.24-6.871 10.392-8.98c6.99 2.052 14.336 4.354 16.45 5.514c3.598 1.971 6.798 10.756 5.828 16.768"/>
                </svg>
            </svg>
            <span class="text-lg font-semibold sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl gradient-text" font-family="Arial, sans-serif">Creative</span>
            <span class="text-lg font-semibold sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl gradient-text" font-family="Arial, sans-serif">Hub</span>
        </div>


    <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
