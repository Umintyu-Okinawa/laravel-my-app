document.addEventListener("DOMContentLoaded", function () {
    const audio = document.getElementById("sazako-audio");
    const content = document.getElementById("post-content");
    const overlay = document.getElementById("sazako-overlay");

    if (content && content.textContent.includes("サザコ")) {
        overlay.style.display = "block";
        document.body.style.overflow = "hidden";

        try {
            audio.volume = 1.0; // 念のため最大音量
            audio.play().catch((e) => {
                console.warn(
                    "音声自動再生がブロックされた可能性があります。",
                    e
                );
            });
        } catch (err) {
            console.error("音声再生エラー:", err);
        }
    }

    // Escapeキーで終了
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            overlay.style.display = "none";
            audio.pause();
            audio.currentTime = 0;
            document.body.style.overflow = "";
        }
    });
});
