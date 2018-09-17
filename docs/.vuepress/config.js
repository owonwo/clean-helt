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
            ['/admin/','Admin'],
            ['/hospitals/', 'Hospitals'],
            ['/pharmacies/', 'Pharmacies'],
            ['/patient/', 'Patient'],
            ['/laboratory/', 'Laboratory'],
            ['/general/', 'General Concerns']
        ],
    }
};