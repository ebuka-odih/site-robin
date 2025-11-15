@extends('dashboard.new-layout')

@section('content')
<div class="space-y-8 text-white">
    <div class="flex flex-col gap-1">
        <p class="text-[11px] uppercase tracking-[0.3em] text-[#08f58d]">Funding</p>
        <h1 class="text-2xl font-semibold">Deposit funds</h1>
        <p class="text-sm text-gray-400">Top up your wallets with streamlined steps and transparent history.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div class="rounded-3xl border border-[#111] bg-[#050505] p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Trading balance</p>
            <p class="text-2xl font-semibold">${{ number_format($user->balance ?? 0, 2) }}</p>
            <p class="text-xs text-gray-500">Available for live trades.</p>
        </div>
        <div class="rounded-3xl border border-[#111] bg-[#050505] p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Holding balance</p>
            <p class="text-2xl font-semibold">${{ number_format($user->holding_balance ?? 0, 2) }}</p>
            <p class="text-xs text-gray-500">Long term growth positions.</p>
        </div>
    </div>

    <div class="rounded-[32px] border border-[#101010] bg-[#040404] p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="space-y-1">
                <p class="text-[11px] uppercase tracking-[0.3em] text-gray-500">Instant Funding</p>
                <p class="text-xl font-semibold">Upload deposit proof and update balances instantly.</p>
                <p class="text-sm text-gray-500">Select wallet, method, and attach proof. We update once approved.</p>
            </div>
            <button id="openDeposit" class="rounded-full bg-[#00ff5f] px-6 py-3 text-black text-sm font-semibold">New deposit</button>
        </div>

        <form id="depositForm" method="POST" action="{{ route('user.payment') }}" enctype="multipart/form-data" class="mt-6 grid gap-4 md:grid-cols-2 hidden">
            @csrf
            <div class="md:col-span-1 space-y-2">
                <label class="text-xs uppercase tracking-wide text-gray-400">Amount</label>
                <input id="amount" name="amount" type="number" step="0.01" min="0.01" value="{{ old('amount') }}" class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c]" placeholder="0.00" required>
            </div>

            <div class="md:col-span-1 space-y-2">
                <label class="text-xs uppercase tracking-wide text-gray-400">Wallet</label>
                <select id="wallet_type" name="wallet_type" class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c]" required>
                    <option value="">Choose wallet</option>
                    <option value="balance" {{ old('wallet_type') == 'balance' ? 'selected' : '' }}>Main balance</option>
                    <option value="trading" {{ old('wallet_type') == 'trading' ? 'selected' : '' }}>Trading</option>
                    <option value="holding" {{ old('wallet_type') == 'holding' ? 'selected' : '' }}>Holding</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-xs uppercase tracking-wide text-gray-400">Payment method</label>
                <select id="payment_method_id" name="payment_method_id" class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c]" required>
                    <option value="">Select method</option>
                    @foreach($wallets as $wallet)
                        <option value="{{ $wallet->id }}" data-address="{{ $wallet->address ?? '' }}" {{ old('payment_method_id') == $wallet->id ? 'selected' : '' }}>
                            {{ $wallet->crypto_display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-xs uppercase tracking-wide text-gray-400">Payment proof</label>
                <input id="proof" name="proof" type="file" class="w-full rounded-2xl border border-dashed border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c]" required>
                <p class="text-xs text-gray-500">Upload screenshot or PDF up to 10MB.</p>
            </div>

            <div class="md:col-span-2 space-y-2 hidden" id="walletAddressWrap">
                <label class="text-xs uppercase tracking-wide text-gray-400">Wallet address</label>
                <div class="rounded-[24px] border border-[#191919] bg-[#030303] p-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <input id="walletAddress" type="text" readonly class="flex-1 bg-transparent text-sm font-mono text-white focus:outline-none">
                    <button type="button" id="copyAddress" class="rounded-full border border-[#1fff9c]/40 px-4 py-2 text-xs font-semibold text-[#1fff9c]">Copy</button>
                </div>
            </div>

            <div class="md:col-span-2 flex flex-wrap gap-3 text-xs text-gray-500">
                <p>Funding window expires in <span id="timer" class="text-[#00ff5f]">15:00</span>.</p>
                <p>Please confirm transaction hash to accelerate verification.</p>
            </div>

            <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
                <button type="submit" id="submitDeposit" class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-[#00ff5f] py-3 text-sm font-semibold text-black">
                    <span id="submitText">Submit deposit</span>
                    <svg id="submitSpinner" class="hidden h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
                <button type="button" id="cancelDeposit" class="flex flex-1 items-center justify-center rounded-2xl border border-[#1f1f1f] py-3 text-sm font-semibold text-gray-400">
                    Cancel
                </button>
            </div>

            @if(session('success'))
                <p class="md:col-span-2 rounded-2xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">{{ session('success') }}</p>
            @endif
            @if(session('error'))
                <p class="md:col-span-2 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">{{ session('error') }}</p>
            @endif
            @if($errors->any())
                <div class="md:col-span-2 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300 space-y-1">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </form>
    </div>

    <div class="rounded-[32px] border border-[#101010] bg-[#040404]">
        <div class="border-b border-[#121212] px-6 py-4 flex items-center justify-between">
            <div>
                <p class="text-sm uppercase tracking-wide text-gray-500">History</p>
                <p class="text-lg font-semibold">Deposits timeline</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs uppercase tracking-wide text-gray-500">
                    <tr class="grid grid-cols-7 border-b border-[#121212] px-6 py-3">
                        <th class="text-left">Amount</th>
                        <th class="text-left">Wallet</th>
                        <th class="text-left">Method</th>
                        <th class="text-left">Address</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#0f0f0f]">
                    @forelse($deposits as $deposit)
                        <tr class="grid grid-cols-7 items-center px-6 py-4">
                            <td>${{ number_format($deposit->amount, 2) }}</td>
                            <td>{{ ucfirst($deposit->wallet_type) }}</td>
                            <td>{{ $deposit->payment_method->crypto_display_name ?? '—' }}</td>
                            <td class="text-xs text-gray-500 truncate">{{ $deposit->payment_method->address ?? '—' }}</td>
                            <td>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $deposit->status == 1 ? 'bg-[#0f2b14] text-[#00ff5f]' : ($deposit->status == 2 ? 'bg-[#2b0f0f] text-[#ff4d4d]' : 'bg-[#1f1f1f] text-gray-300') }}">
                                    {{ $deposit->status_badge_text ?? 'Pending' }}
                                </span>
                            </td>
                            <td>{{ $deposit->created_at->format('M d, Y') }}</td>
                            <td class="text-right space-x-3 text-xs">
                                @if($deposit->proof)
                                    <a href="{{ route('user.deposit.proof', $deposit->id) }}" class="text-[#00ff5f]">View proof</a>
                                @endif
                                @if($deposit->status == 0)
                                    <button onclick="cancelDeposit('{{ $deposit->id }}')" class="text-red-400">Cancel</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 text-sm">No deposits yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('depositForm');
    const openButton = document.getElementById('openDeposit');
    const cancelButton = document.getElementById('cancelDeposit');
    const paymentSelect = document.getElementById('payment_method_id');
    const addressWrap = document.getElementById('walletAddressWrap');
    const addressInput = document.getElementById('walletAddress');
    const copyBtn = document.getElementById('copyAddress');
    const submitBtn = document.getElementById('submitDeposit');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    const timerEl = document.getElementById('timer');
    let countdown;

    openButton.addEventListener('click', () => {
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            let remaining = 15 * 60;
            timerEl.textContent = formatTime(remaining);
            countdown = setInterval(() => {
                remaining--;
                timerEl.textContent = formatTime(remaining);
                if (remaining <= 0) clearInterval(countdown);
            }, 1000);
        } else if (countdown) clearInterval(countdown);
    });

    cancelButton.addEventListener('click', () => {
        form.reset();
        form.classList.add('hidden');
        addressWrap.classList.add('hidden');
        if (countdown) clearInterval(countdown);
    });

    paymentSelect.addEventListener('change', (e) => {
        const selected = e.target.selectedOptions[0];
        const address = selected?.dataset.address || '';
        if (address) {
            addressInput.value = address;
            addressWrap.classList.remove('hidden');
        } else {
            addressWrap.classList.add('hidden');
        }
    });

    copyBtn.addEventListener('click', async () => {
        const address = addressInput.value || '';
        
        if (!address) {
            copyBtn.textContent = 'No address!';
            setTimeout(() => copyBtn.textContent = 'Copy', 1500);
            return;
        }

        try {
            // Try modern clipboard API first
            if (navigator.clipboard && navigator.clipboard.writeText) {
                await navigator.clipboard.writeText(address);
                copyBtn.textContent = 'Copied!';
                copyBtn.classList.add('bg-[#1fff9c]', 'text-black');
                copyBtn.classList.remove('border-[#1fff9c]/40', 'text-[#1fff9c]');
                setTimeout(() => {
                    copyBtn.textContent = 'Copy';
                    copyBtn.classList.remove('bg-[#1fff9c]', 'text-black');
                    copyBtn.classList.add('border-[#1fff9c]/40', 'text-[#1fff9c]');
                }, 1500);
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = address;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                
                try {
                    document.execCommand('copy');
                    copyBtn.textContent = 'Copied!';
                    copyBtn.classList.add('bg-[#1fff9c]', 'text-black');
                    copyBtn.classList.remove('border-[#1fff9c]/40', 'text-[#1fff9c]');
                    setTimeout(() => {
                        copyBtn.textContent = 'Copy';
                        copyBtn.classList.remove('bg-[#1fff9c]', 'text-black');
                        copyBtn.classList.add('border-[#1fff9c]/40', 'text-[#1fff9c]');
                    }, 1500);
                } catch (err) {
                    console.error('Fallback copy failed:', err);
                    copyBtn.textContent = 'Failed!';
                    setTimeout(() => copyBtn.textContent = 'Copy', 1500);
                } finally {
                    document.body.removeChild(textArea);
                }
            }
        } catch (err) {
            console.error('Copy failed:', err);
            copyBtn.textContent = 'Failed!';
            setTimeout(() => copyBtn.textContent = 'Copy', 1500);
        }
    });

    form.addEventListener('submit', () => {
        submitBtn.disabled = true;
        submitSpinner.classList.remove('hidden');
        submitText.textContent = 'Submitting...';
    });

    window.cancelDeposit = (id) => {
        if (confirm('Cancel this deposit?')) {
            window.location.href = `/user/deposit/cancel/${id}`;
        }
    };

    function formatTime(seconds) {
        const m = String(Math.floor(seconds / 60)).padStart(2, '0');
        const s = String(seconds % 60).padStart(2, '0');
        return `${m}:${s}`;
    }
});
</script>
@endsection
