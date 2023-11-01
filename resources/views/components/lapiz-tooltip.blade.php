<span x-data="{ tooltip: false }" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false"
    class="-mt-4 ml-2 w-4 h-6 cursor-pointer">
    <svg class="w-8 h-8 -mt-4" <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px"><rect width="8" height="41" x="19.621" y="3.879" fill="#3ddab4" transform="rotate(45.001 23.621 24.379)"/><rect width="8" height="7" x="34.47" y="6.03" fill="#f5bc00" transform="rotate(45.001 38.47 9.53)"/><rect width="3" height="8" x="34.167" y="8.333" fill="#00b569" transform="rotate(-45.001 35.667 12.333)"/><polygon fill="#3ddab4" points="4.226,43.774 6.297,36.046 11.954,41.703"/><polygon fill="#00b569" points="7.677,42.849 5.153,40.317 4.226,43.774"/></svg>

  <div x-show="tooltip" 
    class="text-md text-white relative mr-1 bg-blue-400 rounded-lg p-0.5 transform translate-x-1" >
      {{$slot}}
  </div>
</span>