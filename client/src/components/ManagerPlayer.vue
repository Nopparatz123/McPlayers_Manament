<template>
    <div class="flex justify-center items-center">
        <div class="container-sm mx-auto mt-8">
            <div class="w-full min-h-[200px] bg-white dark:bg-neutral-800 shadow-md rounded-2xl p-7">
                <div class="flex justify-between items-center mb-5">
                    <h1 class="text-2xl font-semibold dark:text-white"><i class="bi bi-list-ul"></i> Player List</h1>
                    <button
                        @click="getPlayers"
                        class="p-1 px-3 rounded-xl bg-sky-700 transition hover:bg-sky-800 text-white dark:bg-orange-400 dark:hover:bg-orange-500">
                        <i class="bi bi-arrow-clockwise"></i> Refresh Player
                    </button>
                </div>

                <!-- เมื่อมีข้อมูล -->
                <div v-if="dataServer?.players?.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="col-span-1" v-for="(player, index) in dataServer.players" :key="index">
                        <div
                            class="w-full h-16 shadow-md bg-white dark:bg-transparent p-5 flex justify-between items-center rounded-xl">
                            <img src="https://cdnb.artstation.com/p/assets/images/images/027/406/795/large/ilya-vdovyuk-556.jpg?1591447233"
                                class="rounded-full" width="45" alt="Player Image">
                            <div class="ml-5">
                                <h1 class="text-1xl font-semibold dark:text-white">{{ player }}</h1>
                                <p class="text-green-600 dark:text-green-400">Status: Online</p>
                            </div>

                            <button @click="showModal(player)"
                                class="py-1 px-2 rounded-xl bg-sky-700 text-white transition hover:bg-sky-800 ms-4 dark:bg-orange-400 dark:hover:bg-orange-500">
                                Manager
                            </button>

                            <!-- Modal managerPlayer -->
                            <dialog :id="'my_modal_' + player" class="modal modal-bottom sm:modal-middle">
                                <div class="modal-box bg-white rounded-xl">
                                    <h3 class="font-bold text-2xl">{{ player }}</h3>
                                    <div class="modal-action flex justify-center flex-col gap-2">
                                        <button @click="sendAction(player, 'kick')" class="w-full h-8 rounded-xl bg-blue-700 text-white transition hover:bg-blue-800">
                                            Kick
                                        </button>
                                        <button @click="sendAction(player, 'kill')" class="w-full h-8 rounded-xl bg-red-700 text-white transition hover:bg-red-800">
                                            Killer
                                        </button>
                                        <button click="sendAction(player, 'rsHeart')" class="w-full h-8 rounded-xl bg-green-700 text-white transition hover:bg-green-800">
                                            Reset Heart
                                        </button>
                                        <form method="dialog" class="w-full">
                                            <button class="w-full h-8 rounded-xl bg-sky-700 text-white transition hover:bg-sky-800 dark:bg-orange-400 dark:hover:bg-orange-500">
                                                Close
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>

                        </div>
                    </div>
                </div>


                <div v-else class="h-32 px-30 flex justify-center items-center text-gray-500 dark:text-gray-300">
                    ไม่มีผู้เล่นออนไลน์
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ManagerPlayer',
    data() {
        return {
            dataServer: null,
            error: null,
        };
    },
    methods: {
        // send
        async sendAction(playerName, type){
            try{
                await fetch("http://localhost/server/controlPlayers.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        command: type,
                        target: playerName
                    })
                });
                console.log(`kick ${playerName} `);
                window.location.href = '/manament'
            }catch(err){
                console.error(err);
            }
        },

        // ----------------------------------------------

        // โชว์modal
        showModal(playerName) {
            const modal = document.getElementById(`my_modal_${playerName}`);
            if (modal) {
                modal.showModal();
                console.log(`${playerName}`);
            } else {
                console.error(`Modal with id my_modal_${playerName} not found`);
            }
        },
        // ----------------------------------------------

        // ดึงข้อมูลผู้เล่น
        async getPlayers() {
            try {
                const response = await fetch('http://localhost/server/getPlayers.php');
                if (!response.ok) throw new Error('Failed to fetch data');

                const data = await response.json();

                if (data.error || !data.players) {
                    this.dataServer = null;
                    this.error = 'ไม่มีข้อมูลให้แสดง';
                } else {
                    this.error = null;
                    this.dataServer = data;
                }
            } catch (err) {
                this.error = err.message;
                this.dataServer = null;
            }
        },
        // ----------------------------------------------
    },
    mounted() {
        this.getPlayers();
    },
}
</script>

