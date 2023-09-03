let startTime;
        let interval;
        let pausedTime = 0;

        const timerElement = document.getElementById('timer');
        const startButton = document.getElementById('start');
        const pauseButton = document.getElementById('pause');
        const resumeButton = document.getElementById('resume');

        function formatMilliseconds(milliseconds) {
            const seconds = Math.floor(milliseconds / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);

            const formattedHours = String(hours).padStart(2, '0');
            const formattedMinutes = String(minutes % 60).padStart(2, '0');
            const formattedSeconds = String(seconds % 60).padStart(2, '0');

            return `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
        }

        function updateTimer() {
            const currentTime = new Date().getTime();
            const elapsedTime = currentTime - startTime + pausedTime;
            timerElement.textContent = formatMilliseconds(elapsedTime);
        }

        startButton.addEventListener('click', () => {
            startTime = new Date().getTime();
            interval = setInterval(updateTimer, 1000); // Update every 1 second (1000 milliseconds)
        });

        pauseButton.addEventListener('click', () => {
            clearInterval(interval);
            pausedTime += new Date().getTime() - startTime;
        });

        resumeButton.addEventListener('click', () => {
            startTime = new Date().getTime();
            interval = setInterval(updateTimer, 1000);
        });