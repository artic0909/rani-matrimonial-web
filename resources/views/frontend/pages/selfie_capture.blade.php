<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Take Selfie - Rani Matrimonial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .theme-btn {
            background: linear-gradient(to right, #D4AF37, #C59B27);
            color: #4a0404;
        }
    </style>
</head>
<body class="bg-[#2a0202] min-h-screen flex flex-col font-sans text-white relative">
    <!-- Header -->
    <div class="p-4 flex items-center justify-center border-b border-white/10 bg-[#4a0404]/50">
        <h1 class="text-xl font-serif font-bold text-[#D4AF37]">Rani Matrimonial</h1>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col p-6 items-center justify-center relative" id="app">
        
        <!-- Intro State -->
        <div id="intro" class="w-full text-center max-w-sm">
            <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 text-[#D4AF37] border border-[#D4AF37]/30">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold mb-3">Identity Verification</h2>
            <p class="text-gray-300 mb-8 text-sm leading-relaxed">
                Please take a clear selfie to verify your identity. This photo must match your uploaded profile picture.
            </p>
            <button onclick="startCamera()" class="w-full theme-btn py-4 rounded-xl font-bold text-lg shadow-lg">
                Open Camera
            </button>
        </div>

        <!-- Camera State -->
        <div id="camera-container" class="w-full max-w-sm hidden flex-col items-center">
            <p class="text-sm mb-4 text-[#D4AF37] font-medium text-center">Position your face in the center</p>
            <div class="w-full aspect-[3/4] bg-black rounded-2xl overflow-hidden border-2 border-[#D4AF37] relative shadow-2xl">
                <video id="video" autoplay playsinline class="w-full h-full object-cover transform scale-x-[-1]"></video>
                <!-- Face Guide Overlay -->
                <div class="absolute inset-0 border-[6px] border-dashed border-white/30 rounded-[100px] m-8 pointer-events-none"></div>
            </div>
            
            <button onclick="takeSnapshot()" class="mt-8 bg-white text-[#4a0404] w-20 h-20 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(212,175,55,0.5)] border-4 border-[#D4AF37]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
            </button>
        </div>

        <!-- Success State -->
        <div id="success" class="w-full text-center max-w-sm hidden">
            <div class="w-24 h-24 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-green-400 border border-green-500/50 shadow-[0_0_30px_rgba(74,222,128,0.2)]">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-2xl font-bold mb-3 text-[#D4AF37]">Selfie Verified!</h2>
            <p class="text-gray-300 text-sm leading-relaxed mb-8">
                Your selfie has been securely sent to your PC.
            </p>
            <div class="p-4 bg-white/10 rounded-xl border border-white/20">
                <p class="font-medium text-white">You can now safely close this tab and return to your PC to finish registration.</p>
            </div>
        </div>

    </div>

    <!-- Hidden Canvas -->
    <canvas id="canvas" class="hidden"></canvas>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const mobileNumber = "{{ $mobile }}";
        let stream = null;

        function startCamera() {
            // Must be HTTPS in production
            if (window.location.protocol !== 'https:' && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
                alert("Camera requires a secure HTTPS connection. Please use HTTPS.");
                return;
            }

            document.getElementById('intro').classList.add('hidden');
            document.getElementById('camera-container').classList.remove('hidden');
            document.getElementById('camera-container').classList.add('flex');

            navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'user' }, 
                audio: false 
            })
            .then(mediaStream => {
                stream = mediaStream;
                video.srcObject = stream;
            })
            .catch(err => {
                alert("Please allow camera permissions to take a selfie.");
                document.getElementById('camera-container').classList.add('hidden');
                document.getElementById('camera-container').classList.remove('flex');
                document.getElementById('intro').classList.remove('hidden');
                console.error(err);
            });
        }

        function takeSnapshot() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            
            // Mirror image on canvas to match video
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataUrl = canvas.toDataURL('image/jpeg', 0.8);

            // Stop camera
            stream.getTracks().forEach(track => track.stop());

            uploadSelfie(dataUrl);
        }

        function uploadSelfie(dataUrl) {
            document.getElementById('camera-container').classList.add('hidden');
            document.getElementById('camera-container').classList.remove('flex');
            
            // Show loading
            document.getElementById('intro').innerHTML = `
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#D4AF37] mx-auto mb-4"></div>
                <p class="text-[#D4AF37]">Uploading...</p>
            `;
            document.getElementById('intro').classList.remove('hidden');

            fetch('/api/save-phone-selfie', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    mobile: mobileNumber,
                    selfie_data: dataUrl
                })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('intro').classList.add('hidden');
                if(data.success) {
                    document.getElementById('success').classList.remove('hidden');
                } else {
                    alert("Upload failed. Please try again.");
                    window.location.reload();
                }
            })
            .catch(err => {
                alert("Network error. Please try again.");
                window.location.reload();
            });
        }
    </script>
</body>
</html>
