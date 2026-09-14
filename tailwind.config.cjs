const path = require('path');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    path.join(__dirname, 'resources/**/*.blade.php'),
    path.join(__dirname, 'resources/**/*.js'),
    path.join(__dirname, 'app/**/*.php'),
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './app/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: "#0A0A0A",
        secondary: "#111111",
        accent: "#B08D57",
        "accent-dark": "#967543",
        "neutral-body": "#6B7280",
        "neutral-bg": "#F8F9FA",
        "neutral-dark": "#0A0A0A",
      },
      fontFamily: {
        sans: ["Poppins", "Inter", "system-ui", "-apple-system", "sans-serif"],
        display: ["Poppins", "Inter", "sans-serif"],
      },
      letterSpacing: {
        widest2: "0.25em",
        widest3: "0.35em",
      },
    },
  },
  plugins: [],
}
