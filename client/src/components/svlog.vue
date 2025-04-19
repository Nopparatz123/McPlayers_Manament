<template>
    <div class="flex justify-center mt-13">
        <div>
            <div class="flex justify-between mb-3">

                <!-- status error -->
                <div class="flex gap-4">
                    <div class="relative inline-flex">
                        <button
                            class="rounded-md bg-red-600 py-1 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg   active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Error!!
                        </button>
                        <span v-if="logCount.error" class="badgeError">
                            {{ logCount.error }}
                        </span>
                        <span v-else class="badgeError">
                            0
                        </span>
                    </div>

                    <div class="relative inline-flex">
                        <button
                            class="rounded-md bg-yellow-600 py-1 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg   active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Warning
                        </button>
                        <span v-if="logCount.warning" class="badgeWarning">
                            {{ logCount.warning }}
                        </span>
                        <span v-else class="badgeWarning">
                            0
                        </span>
                    </div>

                    <div class="relative inline-flex">
                        <button
                            class="rounded-md bg-green-700 py-1 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg   active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Success
                        </button>
                        <span v-if="logCount.success" class="badgeSuccess">
                            {{ logCount.success }}
                        </span>
                        <span v-else class="badgeSuccess">
                            0
                        </span>
                    </div>
                </div>
                <!-- end status -->
                <button @click="getLog"
                    class="p-1 px-3 rounded-xl bg-neutral-700 transition hover:bg-neutral-800  text-white">
                    <i class="bi bi-arrow-clockwise"></i> Refresh ServerLog
                </button>
            </div>


            <pre v-if="dataLog" class="language-log"><code class="language-log">{{ dataLog }}</code></pre>
            <pre v-else class="language-log"><code class="language-log">ไม่มีข้อมูลให้แสดง😭</code></pre>
        </div>
    </div>
</template>

<script>
export default {
    name: 'svlog',
    data() {
        return {
            dataLog: "",
            logCount: {
                error: 0,
                warning: 0,
                success: 0,
            },
        };
    },
    methods: {
        async getLog() {
            try {
                const response = await fetch('http://localhost/server/svlog.php') //url phpapi logเซิฟ
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }

                const logData = await response.text();


                if (logData.error) {
                    console.error('เกิดข้อผิดพลาด ไม่พบข้อมูล')
                    this.dataLog = null;
                } else {
                    this.dataLog = logData;
                    this.countLog(logData);
                    this.$nextTick(() => {
                        Prism.highlightAll();
                    });
                    // console.log(logData);
                }
            } catch (err) {
                console.error('เกิดข้อผิดพลาด')
            }
        },
        // 
        countLog(logText) {
            const lines = logText.split("\n");
            let error = 0, warning = 0, success = 0;

            lines.forEach((line) => {
                const lower = line.toLowerCase();
                if (/\[warn\]/i.test(line)) warning++;
                if (/\[error\]/i.test(line) || /failed|fail/i.test(line)) error++;
                if (/done|successfully|enabled/i.test(line)) success++;
            });
            this.logCount = { error, warning, success };
        },
    },
    mounted() {
        this.getLog();
    }
} 
</script>

<style>
pre[class*="language-"] {
    background: rgb(37, 37, 41);
    padding: 1rem;
    border-radius: 0.75rem;
    font-family: 'Fira Code', monospace;
    font-size: 0.875rem;
    overflow-x: auto;
    color: white;
    max-width: 70rem;
    overflow-y: auto;
}

.token.comment {
    color: #6a9955;
}

.token.keyword {
    color: #569cd6;
}

.token.string {
    color: #ce9178;
}
</style>
