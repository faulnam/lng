<!-- Nusantara LNG AI Chatbot Widget (Ultra Clean Architectural Minimalist) -->
<div x-data="nusantaraLngChatbot()" x-init="init()" class="relative font-sans text-[#111111]" x-cloak>
    
    <!-- Proactive Teaser Banner (Clean Minimalist Monochrome) -->
    <div x-show="showTeaser && !isOpen"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         class="fixed bottom-24 right-6 z-50 max-w-[290px] bg-white text-black p-4 shadow-xl border border-neutral-300 flex items-start gap-3 select-none">
        
        <!-- Square N Emblem (Identical to Header Logo) -->
        <div class="w-7 h-7 bg-black text-white flex items-center justify-center font-bold text-xs tracking-tighter shrink-0">
            N
        </div>
        <div class="flex-1 cursor-pointer" @click="openChat()">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-black">
                LNG Energy Assistant
            </p>
            <p class="text-xs text-neutral-600 leading-snug mt-1 font-normal">
                Butuh data spesifikasi LNG, virtual pipeline, atau skema kontrak pasokan? Tanya di sini.
            </p>
        </div>
        <button @click.stop="dismissTeaser()" class="text-neutral-400 hover:text-black text-base p-0.5 leading-none transition-colors" title="Tutup">
            &times;
        </button>
    </div>

    <!-- Floating Action Button (Clean Minimalist Button) -->
    <button @click="toggleChat()"
            class="fixed bottom-6 right-6 z-50 w-13 h-13 md:w-14 md:h-14 bg-black text-white border border-black hover:bg-white hover:text-black shadow-2xl flex items-center justify-center transition-all duration-300 group focus:outline-none"
            :class="{ 'bg-white text-black': isOpen }"
            aria-label="Asisten AI Nusantara LNG">
        
        <!-- Chat Icon (Closed) -->
        <svg x-show="!isOpen" class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>

        <!-- Close Icon (Open) -->
        <svg x-show="isOpen" class="w-5 h-5 transition-transform duration-200 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Chat Window Modal (Clean Architectural Window) -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-250 transform"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-24 right-4 sm:right-6 z-50 w-[92vw] sm:w-[420px] h-[590px] max-h-[calc(100vh-120px)] bg-white border border-neutral-300 shadow-2xl flex flex-col overflow-hidden">
        
        <!-- Minimalist Header -->
        <div class="bg-black text-white px-5 py-4 flex items-center justify-between border-b border-black shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 bg-white text-black flex items-center justify-center font-bold text-xs tracking-tighter shrink-0">
                    N
                </div>
                <div>
                    <h3 class="text-xs font-bold tracking-[0.22em] uppercase text-white leading-none">
                        NUSANTARA LNG
                    </h3>
                    <p class="text-[9px] tracking-[0.2em] uppercase text-neutral-400 mt-1">
                        Corporate Energy AI Assistant
                    </p>
                </div>
            </div>

            <!-- Header Action Buttons -->
            <div class="flex items-center gap-1">
                <!-- Clear History -->
                <button @click="confirmClearChat()" 
                        class="p-1.5 text-neutral-400 hover:text-white transition-colors" 
                        title="Hapus riwayat percakapan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
                
                <!-- Close Window -->
                <button @click="isOpen = false" 
                        class="p-1.5 text-neutral-400 hover:text-white transition-colors" 
                        title="Tutup">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Message Body -->
        <div x-ref="chatContainer" class="flex-1 overflow-y-auto p-4 space-y-4 bg-white scroll-smooth">
            
            <!-- Welcome Info Card (Minimal Clean) -->
            <div class="bg-neutral-50 p-4 border border-neutral-200 space-y-3">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Pusat Informasi Energi B2B</span>
                    <p class="text-xs text-neutral-700 leading-relaxed mt-1">
                        Selamat datang di <strong>PT Nusantara LNG Energi</strong>. Konsultasikan spesifikasi teknis gas alam cair (LNG), skema kontrak pasokan (FOB/DES), logistik virtual pipeline ISO tank, atau kebutuhan energi industri Anda.
                    </p>
                </div>
                
                <!-- Quick Suggestions Chips (Clean Outline Style) -->
                <div class="pt-2 border-t border-neutral-200">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-neutral-500 mb-2">Topik Pertanyaan Populer:</p>
                    <div class="flex flex-col gap-1.5">
                        <template x-for="(sug, index) in suggestions" :key="index">
                            <button @click="sendPredefined(sug.prompt)" 
                                    class="text-left text-xs bg-white hover:bg-black hover:text-white text-neutral-800 px-3 py-2 border border-neutral-200 hover:border-black transition-all duration-150 flex items-center justify-between group">
                                <span x-text="sug.label"></span>
                                <span class="text-[10px] text-neutral-400 group-hover:text-white transition-colors">&rarr;</span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Messages List -->
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex flex-col" :class="msg.role === 'user' ? 'items-end' : 'items-start'">
                    
                    <!-- Sender & Time Tag -->
                    <div class="flex items-center gap-1.5 mb-1 text-[9px] uppercase tracking-wider text-neutral-400 px-0.5">
                        <span x-text="msg.role === 'user' ? 'Anda' : 'Nusantara LNG AI'"></span>
                        <span>•</span>
                        <span x-text="msg.time"></span>
                    </div>

                    <!-- Message Bubble -->
                    <div class="max-w-[90%] px-4 py-3 text-xs leading-relaxed transition-all"
                         :class="msg.role === 'user' 
                            ? 'bg-black text-white border border-black' 
                            : 'bg-neutral-50 text-neutral-900 border border-neutral-200'">
                        
                        <!-- Content -->
                        <div class="metrix-chat-body prose prose-xs max-w-none break-words" x-html="renderMarkdown(msg.text)"></div>
                    </div>

                    <!-- Copy Button for Model Response -->
                    <template x-if="msg.role === 'model'">
                        <div class="flex items-center gap-2 mt-1 px-0.5">
                            <button @click="copyText(msg.text, $event)" 
                                    class="text-[9px] uppercase tracking-wider text-neutral-400 hover:text-black flex items-center gap-1 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <span>Salin Teks</span>
                            </button>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Thinking / Generating State (Ultra Clean Monochrome) -->
            <div x-show="isThinking" 
                 x-transition
                 class="flex flex-col items-start space-y-1">
                
                <div class="text-[9px] uppercase tracking-wider text-neutral-400 px-0.5">
                    Nusantara LNG AI • Memproses
                </div>

                <div class="bg-neutral-50 border border-neutral-200 px-4 py-3 max-w-[90%] flex items-center gap-3">
                    <!-- Clean Monochrome Dots -->
                    <div class="flex space-x-1">
                        <span class="w-1.5 h-1.5 bg-black rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                        <span class="w-1.5 h-1.5 bg-black rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                        <span class="w-1.5 h-1.5 bg-black rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                    </div>
                    <span class="text-xs text-neutral-600 font-normal" x-text="thinkingStatus"></span>
                </div>
            </div>

            <!-- Error Banner -->
            <div x-show="errorMessage" 
                 x-transition
                 class="p-3 bg-neutral-100 border border-neutral-400 text-neutral-800 text-xs flex items-center justify-between">
                <span x-text="errorMessage"></span>
                <button @click="errorMessage = ''" class="text-black font-bold ml-2">&times;</button>
            </div>
        </div>

        <!-- Clean Input Box -->
        <div class="p-3 bg-white border-t border-neutral-200 shrink-0">
            <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                <div class="flex-1 bg-white border border-neutral-300 focus-within:border-black transition-colors">
                    <input type="text" 
                           x-model="userInput" 
                           placeholder="Ketik pertanyaan LNG atau konsultasi energi Anda..." 
                           class="w-full px-3 py-2.5 bg-transparent border-0 text-xs text-black placeholder:text-neutral-400 focus:outline-none"
                           :disabled="isThinking">
                </div>

                <!-- Minimalist Black Send Button -->
                <button type="submit" 
                        :disabled="!userInput.trim() || isThinking"
                        class="h-9 px-4 bg-black text-white text-[11px] font-medium tracking-widest uppercase hover:bg-neutral-800 disabled:opacity-30 disabled:cursor-not-allowed border border-black transition-all shrink-0 flex items-center justify-center"
                        title="Kirim">
                    <span>Kirim</span>
                </button>
            </form>
            
            <div class="flex items-center justify-between mt-2 px-0.5 text-[9px] uppercase tracking-wider text-neutral-400">
                <span>Tekan Enter untuk mengirim</span>
                <span>PT Nusantara LNG Energi</span>
            </div>
        </div>
    </div>
</div>

<!-- Clean Styles for Markdown Typography -->
<style>
.metrix-chat-body p {
    margin-bottom: 0.5rem;
}
.metrix-chat-body p:last-child {
    margin-bottom: 0;
}
.metrix-chat-body strong {
    font-weight: 700;
    color: inherit;
}
.metrix-chat-body ul {
    list-style-type: disc;
    margin-left: 1.1rem;
    margin-bottom: 0.5rem;
}
.metrix-chat-body ol {
    list-style-type: decimal;
    margin-left: 1.1rem;
    margin-bottom: 0.5rem;
}
.metrix-chat-body li {
    margin-bottom: 0.25rem;
}
.metrix-chat-body a {
    text-decoration: underline;
    font-weight: 600;
    color: inherit;
}
.metrix-chat-body em {
    font-style: italic;
}
</style>

<!-- Alpine.js Logic -->
<script>
function nusantaraLngChatbot() {
    return {
        isOpen: false,
        showTeaser: false,
        userInput: '',
        isThinking: false,
        thinkingStatus: 'Sedang memproses data teknis LNG...',
        thinkingInterval: null,
        errorMessage: '',
        messages: [],
        suggestions: [
            {
                label: 'Spesifikasi & Nilai Kalor LNG',
                prompt: 'Apa spesifikasi teknis gas alam cair (LNG) Nusantara LNG, termasuk kemurnian metana dan nilai kalornya?'
            },
            {
                label: 'Mekanisme Kontrak FOB & DES',
                prompt: 'Jelaskan skema kontrak pasokan bulk LNG (FOB vs DES) dan mekanisme penentuan harga terindeks.'
            },
            {
                label: 'Virtual Pipeline & ISO Tank',
                prompt: 'Bagaimana solusi logistik virtual pipeline ISO tank untuk menyuplai gas ke kawasan industri atau smelter off-grid?'
            },
            {
                label: 'Standar Keselamatan & QHSE',
                prompt: 'Apa saja standar keselamatan kriogenik, sertifikasi SIGTTO, dan kepatuhan lingkungan yang diterapkan Nusantara LNG?'
            }
        ],

        init() {
            const saved = sessionStorage.getItem('nusantara_lng_chat_history');
            if (saved) {
                try {
                    this.messages = JSON.parse(saved);
                } catch(e) {
                    this.messages = [];
                }
            }

            // Minimalist teaser shown after 3.5 seconds if unopened
            setTimeout(() => {
                if (!this.isOpen && this.messages.length === 0) {
                    this.showTeaser = true;
                }
            }, 3500);
        },

        openChat() {
            this.isOpen = true;
            this.showTeaser = false;
            this.scrollToBottom();
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.showTeaser = false;
                this.scrollToBottom();
            }
        },

        dismissTeaser() {
            this.showTeaser = false;
        },

        sendPredefined(prompt) {
            this.userInput = prompt;
            this.sendMessage();
        },

        async sendMessage() {
            const text = this.userInput.trim();
            if (!text || this.isThinking) return;

            this.errorMessage = '';
            const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            this.messages.push({
                role: 'user',
                text: text,
                time: currentTime
            });

            this.userInput = '';
            this.saveHistory();
            this.scrollToBottom();

            this.isThinking = true;
            this.startThinkingAnimation();

            try {
                const historyPayload = this.messages.map(m => ({
                    role: m.role === 'user' ? 'user' : 'model',
                    text: m.text
                }));

                const response = await fetch('{{ route("chatbot.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: text,
                        history: historyPayload.slice(-8)
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    const replyTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    this.messages.push({
                        role: 'model',
                        text: data.reply,
                        time: replyTime
                    });
                    this.saveHistory();
                } else {
                    this.errorMessage = data.message || 'Terjadi kendala saat memproses jawaban.';
                }
            } catch (error) {
                console.error('Chatbot error:', error);
                this.errorMessage = 'Koneksi terputus. Silakan coba kembali.';
            } finally {
                this.isThinking = false;
                this.stopThinkingAnimation();
                this.scrollToBottom();
            }
        },

        startThinkingAnimation() {
            const statuses = [
                'Sedang memproses data teknis LNG...',
                'Menyiapkan rincian rantai pasok energi...',
                'Menganalisis parameter logistik kriogenik...'
            ];
            let index = 0;
            this.thinkingStatus = statuses[0];
            this.thinkingInterval = setInterval(() => {
                index = (index + 1) % statuses.length;
                this.thinkingStatus = statuses[index];
            }, 1800);
        },

        stopThinkingAnimation() {
            if (this.thinkingInterval) {
                clearInterval(this.thinkingInterval);
                this.thinkingInterval = null;
            }
        },

        confirmClearChat() {
            if (confirm('Hapus seluruh riwayat percakapan?')) {
                this.messages = [];
                sessionStorage.removeItem('nusantara_lng_chat_history');
            }
        },

        saveHistory() {
            try {
                sessionStorage.setItem('nusantara_lng_chat_history', JSON.stringify(this.messages));
            } catch(e) {}
        },

        scrollToBottom() {
            this.$nextTick(() => {
                if (this.$refs.chatContainer) {
                    this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
                }
            });
        },

        copyText(text, event) {
            navigator.clipboard.writeText(text).then(() => {
                const btn = event.currentTarget;
                const orig = btn.innerHTML;
                btn.innerHTML = '<span>Tersalin</span>';
                setTimeout(() => {
                    btn.innerHTML = orig;
                }, 2000);
            });
        },

        renderMarkdown(raw) {
            if (!raw) return '';
            
            let text = raw
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");

            text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            text = text.replace(/\*([^\*\n]+)\*/g, '<em>$1</em>');
            text = text.replace(/^[\*\-]\s+(.+)$/gm, '<li>$1</li>');
            text = text.replace(/(<li>.*<\/li>)/gms, '<ul>$1</ul>');
            text = text.replace(/<\/ul>\s*<ul>/g, '');
            text = text.replace(/^\d+\.\s+(.+)$/gm, '<li>$1</li>');
            text = text.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>');
            text = text.replace(/\n\n+/g, '</p><p>');
            text = text.replace(/\n/g, '<br>');

            return '<p>' + text + '</p>';
        }
    }
}
</script>
