<div x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true' ||
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);

        // Apply dark mode class to html element
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}"
    x-init="
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    "
    class="flex items-center">
    <button
        @click="toggleDarkMode()"
        type="button"
        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
        :class="darkMode ? 'bg-primary-600' : 'bg-gray-200'"
        aria-pressed="false"
        :aria-pressed="darkMode.toString()"
        aria-labelledby="theme-toggle-label">
        <span class="sr-only" id="theme-toggle-label">Toggle dark mode</span>
        <span aria-hidden="true"
              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
              :class="darkMode ? 'translate-x-5' : 'translate-x-0'">
        </span>
    </button>
    <span class="ml-3 text-sm font-medium dark:text-white" x-text="darkMode ? 'Dark' : 'Light'"></span>
</div>
