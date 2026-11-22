/**
 * Tailwind's class strategy is aligned with the `dark` class synchronized by
 * the shared SIRASI-BK theme controller. The current app styles are primarily
 * authored in CSS; this config keeps dark variants ready for utility markup.
 */
module.exports = {
    darkMode: 'class',
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
