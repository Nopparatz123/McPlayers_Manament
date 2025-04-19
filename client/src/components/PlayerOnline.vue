<template>
    <div class="flex justify-center items-center px-4">
        <div class="container max-w-250 mx-auto mt-10">
            <h1 class="text-center font-semibold text-4xl mb-6 text-black dark:text-white">Player Online</h1>

            <!-- bar status จำนวนplayers -->
            <div class=" w-full h-23 bg-white dark:bg-neutral-800  shadow-md rounded-xl p-7 overflow-hidden">
                <div class="flex justify-between">
                    <h1 class="font-semibold text-xl text-black dark:text-white mb-1"><i class="bi bi-server"></i>
                        Minecraft Server1</h1>
                    <h1 class="text-black dark:text-white">
                        <i class="bi bi-people"></i> {{ dataServer?.info?.Players ?? 0 }} / {{
                            dataServer?.info?.MaxPlayers }} Players
                    </h1>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-300 h-3 rounded-xl overflow-hidden">
                    <div class="bg-sky-700 dark:bg-orange-400 h-full rounded-xl"
                        :style="{ width: ((dataServer?.info?.Players / dataServer?.info?.MaxPlayers) * 100 || 0) + '%' }">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center items-center">
        <div class="container max-w-250 mx-auto mt-10">
            <div class="w-full h-auto bg-white dark:bg-neutral-800 shadow-md rounded-xl p-5">
                <h1 class="font-semibold text-2xl mb-4 text-black dark:text-white">List Players</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    <div class="col-span-1" v-for="(player, index) in dataServer?.players || []" :key="index">

                        <div
                            class="w-full h-14 shadow-md bg-white dark:bg-neutral-900 transition p-3 flex justify-between items-center rounded-xl hover:bg-gray-100 dark:hover:bg-neutral-900">
                            <img src="https://cdnb.artstation.com/p/assets/images/images/027/406/795/large/ilya-vdovyuk-556.jpg?1591447233"
                                class="rounded-full" width="45" alt="">
                            <div class="me-19">
                                <h1 class="font-semibold text-sky-600 dark:text-orange-400 text-1xl">{{ player }} | ID :
                                    {{ index + 1 }}</h1>
                            </div>

                            <div class="me-2 text-black dark:text-white">
                                <i class="bi bi-eye-fill"></i>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Playeronline',
    data() {
        return {
            dataServer: null,
            error: null,
        };
    },
    methods: {
        async getPlayers() {
            try {
                const response = await fetch('http://localhost/server/getPlayers.php'); //url php api
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }

                const data = await response.json();

                if (data.error) {
                    this.error = data.error;
                    this.dataServer = null;
                } else {
                    this.error = null;
                    this.dataServer = data;
                }
            } catch (err) {
                this.error = err.message;
                this.serverInfo = null;
            }
        },
    },
    mounted() {
        this.getPlayers();
    },
}

</script>
