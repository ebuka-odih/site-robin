@extends('admin.layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
  <!-- Success/Error Messages -->
  @if(session()->has('success'))
    <div class="mb-6 bg-green-900 border border-green-700 text-green-100 px-4 py-3 rounded-lg">
      {{ session()->get('success') }}
    </div>
  @endif
  @if(session()->has('error'))
    <div class="mb-6 bg-red-900 border border-red-700 text-red-100 px-4 py-3 rounded-lg">
      {{ session()->get('error') }}
    </div>
  @endif

  <div class="mb-6 flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Copied History</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400">List of all user copied trades</p>
    </div>
  </div>

  <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-900/50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Trader</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Trade Count</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Win</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Loss</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">PnL</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
          @foreach($copiedTrades as $trade)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $trade->created_at->format('M d, Y') }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $trade->user->name ?? '—' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $trade->copy_trader?->name ?? '—' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">${{ number_format($trade->amount, 2) }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $trade->trade_count ?? 0 }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $trade->win ?? 0 }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $trade->loss ?? 0 }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
              <span class="{{ ($trade->pnl ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                ${{ number_format($trade->pnl ?? 0, 2) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              @if($trade->status == 1)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
              @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Inactive</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
              <div class="inline-flex items-center gap-2">
                <button onclick="openEditModal({{ $trade->id }}, {{ $trade->trade_count ?? 0 }}, {{ $trade->win ?? 0 }}, {{ $trade->loss ?? 0 }}, {{ $trade->pnl ?? 0 }})" class="px-3 py-1.5 text-xs rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors">Edit PnL</button>
                @if($trade->status == 1)
                  <form method="POST" action="{{ route('admin.copied-trades.deactivate', $trade->id) }}" onsubmit="return confirm('Stop this copied trade? PnL will be transferred to user balance.');" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors">Stop</button>
                  </form>
                @else
                  <form method="POST" action="{{ route('admin.copied-trades.activate', $trade->id) }}" onsubmit="return confirm('Start this copied trade? Only admin can restart stopped trades.');" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 text-xs rounded-md bg-green-600 text-white hover:bg-green-700 transition-colors">Start</button>
                  </form>
                @endif
                <form method="POST" action="{{ route('admin.copied-trades.destroy', $trade->id) }}" onsubmit="return confirm('Are you sure you want to delete this copied trade? This action cannot be undone.');" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="px-3 py-1.5 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors">Delete</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">{{ $copiedTrades->links() }}</div>
  </div>
</div>

<!-- Edit PnL Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
  <div class="relative p-6 border w-80 shadow-lg rounded-md bg-white dark:bg-gray-800">
    <div class="mt-3">
      <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Edit Performance Metrics</h3>
      <form id="editPnlForm" method="POST">
        @csrf
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trade Count</label>
          <input type="number" id="trade_count" name="trade_count" min="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Wins</label>
          <input type="number" id="win" name="win" min="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Losses</label>
          <input type="number" id="loss" name="loss" min="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profit/Loss ($)</label>
          <input type="number" id="pnl" name="pnl" step="0.01" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        </div>
        <div class="flex justify-end space-x-3">
          <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openEditModal(id, tradeCount, win, loss, pnl) {
  document.getElementById('editPnlForm').action = '/admin/copied-trades/' + id + '/edit-pnl';
  document.getElementById('trade_count').value = tradeCount;
  document.getElementById('win').value = win;
  document.getElementById('loss').value = loss;
  document.getElementById('pnl').value = pnl;
  document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
  document.getElementById('editModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeEditModal();
  }
});
</script>
@endsection
