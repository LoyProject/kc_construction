tailwind.config = {
    theme: {
        extend: {
            colors: {
                'brand-black': '#000000',
                'brand-white': '#F9FAFB',
                'brand-gold': '#de911d',
                'brand-gray': '#101720',

                gold: {
                    50: "#fffbea",
                    100: "#fff3c4",
                    200: "#fce588",
                    300: "#fadb5f",
                    400: "#f7c948",
                    500: "#f0b429",
                    600: "#de911d",
                    700: "#cb6e17",
                    800: "#b44d12",
                    900: "#8d2b0b",
                },
            }
        }
    },
    safelist: [
        'font-bold',
        'font-semibold',
        'text-slate-700',
        'bg-red-100',
        'border-red-400',
        'text-red-700',
        'bg-green-100',
        'border-green-400',
        'text-green-700'
    ]
}