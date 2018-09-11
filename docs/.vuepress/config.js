module.exports = {
    title: 'Clean Helt',
    description: 'Medical Records Keeping Application',
    base: '/docs/',
    dest: '.vuepress/../public/docs/',
    themeConfig: {
        sidebarDepth: 2,
        sidebar: [
            '/',
            ['/authentication/', 'Authentication'],
            ['/hospitals/', 'Hospitals'],
            ['/pharmacies/', 'Pharmacies'],
        ],
    }
};