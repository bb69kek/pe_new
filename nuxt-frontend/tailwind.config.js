/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './components/**/*.{js,ts,vue}',
    './layouts/**/*.{js,ts,vue}',
    './plugins/**/*.{js,ts,vue}',
    './app.vue',
  ],
  safelist: [
    {
      pattern: /(col-span|grid-cols)-\d+/,
    },
  ],
  theme: {
    extend: {
      colors: {
          fbg: '#161819',
          bg: '#D9D9D9',
          acc: '#E21339',
          txt: '#ffffff',
          grn: '#00FF4D1A',
          bgm: '#121213'
      },
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
        // Add more fonts as needed
      },
    }
  },
  plugins: [],
}

