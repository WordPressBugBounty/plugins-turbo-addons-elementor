document.addEventListener("DOMContentLoaded", function () {

    function copyTextToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text).then(() => true).catch(() => false);
        } else {
            const textarea = document.createElement("textarea");
            textarea.value = text;
            textarea.style.position = "fixed";
            textarea.style.left = "-9999px";
            textarea.setAttribute("readonly", "");
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand("copy");
                document.body.removeChild(textarea);
                return Promise.resolve(true);
            } catch (err) {
                document.body.removeChild(textarea);
                return Promise.resolve(false);
            }
        }
    }

    const observer = new MutationObserver(() => {
        document.querySelectorAll(".trad_copy_button_text").forEach(copyBtn => {
            if (copyBtn.dataset.bound === "true") return;
            copyBtn.dataset.bound = "true";

            copyBtn.addEventListener("click", async () => {
                let target = copyBtn.getAttribute('data-target');
                let copiedText = copyBtn.getAttribute('data-copied') || 'COPIED';
                let code = '';

                if (target === '3') {
                    code = copyBtn.getAttribute('data-code') || '';
                } else {
                    const codeElement = copyBtn.closest('.trad-coupon-code-inner')?.querySelector('.trad-coupon-code');
                    code = codeElement?.textContent?.trim() || '';
                }

                if (!code) return;

                const originalText = copyBtn.textContent;
                copyBtn.classList.add('active');

                const success = await copyTextToClipboard(code);

                if (success) {
                    copyBtn.textContent = copiedText;
                    setTimeout(() => {
                        copyBtn.textContent = originalText;
                        copyBtn.classList.remove('active');
                    }, 3000);
                }
            });
        });

        if (document.querySelectorAll(".trad_copy_button_text").length > 0) {
            observer.disconnect();
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
});
