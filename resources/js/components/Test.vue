<template>
    <div>
        <h1>Hello, Laravel + Vue!</h1>
        <h2>{{ blog }}</h2>

        <ul>
            <li v-for="link in links">
                <a :href="link.link">{{ link.title }}</a>
            </li>

        </ul>
    </div>
</template>

<script>
export default {
    props: {
        blog: {
            type: String,
            default: 'Kryvorykie'
        }
    },

    data: () => (
        {
            links: [
                {
                    title: "Ютуб",
                    link: "https://www.youtube.com/"
                },

                {
                    title: "ВК",
                    link: "https://www.vk.com/"
                }
            ]
        }
    )
}
</script>

<style scoped>

</style>
