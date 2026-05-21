<x-staff.layout title="News management" page-name="NewsManagement">

	<div x-data="{ pageName: `News management`}">
		<x-staff.partials.breadcrumb/>
	</div>

	<div class="space-y-5 sm:space-y-6">
		<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
			<div class="px-5 py-4 sm:px-6 sm:py-5">
				<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
					<h3 class="text-base font-medium text-gray-800 dark:text-white/90">News list</h3>
					<div class="flex items-center gap-2">
						<a href="{{ route('staff.news.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
							</svg>
							Add News
						</a>
					</div>
				</div>
			</div>

			<div class="p-5 sm:p-6">
				<form method="GET" action="{{ route('staff.news.index') }}" class="grid gap-4 md:grid-cols-4 mb-6">
					<div>
						<label class="mb-1.5 block text-sm font-medium text-gray-700">Search</label>
						<input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="ID or title" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
					</div>

					<div>
						<label class="mb-1.5 block text-sm font-medium text-gray-700">Created range</label>
						<input type="text" name="created_range" value="{{ request('created_range') }}" placeholder="YYYY-MM-DD - YYYY-MM-DD" data-class="flatpickr-right" class="datepicker h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
					</div>

					<div>
						<label class="mb-1.5 block text-sm font-medium text-gray-700">Sort by</label>
						<select name="sort" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
							<option value="published_desc" @selected(request('sort') === 'published_desc')>Published date ↓</option>
							<option value="published_asc" @selected(request('sort') === 'published_asc')>Published date ↑</option>
							<option value="id_desc" @selected(request('sort') === 'id_desc')>ID ↓</option>
							<option value="id_asc" @selected(request('sort') === 'id_asc')>ID ↑</option>
						</select>
					</div>

					<div class="flex items-end gap-2">
						<button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600">Search</button>
						<a href="{{ route('staff.news.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800">Reset</a>
					</div>
				</form>

				<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
					<div class="w-full overflow-x-auto">
						<table class="min-w-full">
							<thead>
								<tr class="border-b border-gray-100 dark:border-gray-800">
									<th class="px-4 pb-3 pt-4 sm:px-6 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p></th>
									<th class="px-4 pb-3 pt-4 sm:px-6 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Title</p></th>
									<th class="px-4 pb-3 pt-4 sm:px-6 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Image</p></th>
									<th class="px-4 pb-3 pt-4 sm:px-6 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Excerpt</p></th>
									<th class="px-4 pb-3 pt-4 sm:px-6 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Created</p></th>
									<th class="px-4 pb-3 pt-4 sm:px-6 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Published</p></th>
									<th class="px-4 pb-3 pt-4 sm:px-6 text-right"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Action</p></th>
								</tr>
							</thead>

							<tbody class="divide-y divide-gray-100 dark:divide-gray-800">
								@foreach($items as $item)
									<tr>
										<td class="px-4 pb-3 pt-4 sm:px-6"><p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $item->id }}</p></td>
										<td class="px-4 pb-3 pt-4 sm:px-6">
											<div class="max-w-md">
												<span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $item->title }}</span>
												<span class="block text-xs text-gray-500 dark:text-gray-400">{{ $item->slug }}</span>
											</div>
										</td>
										<td class="px-4 pb-3 pt-4 sm:px-6">
											<div class="h-12 w-20 overflow-hidden rounded bg-gray-100">
												<img src="{{ $item->image_url }}" alt="" class="h-full w-full object-cover" />
											</div>
										</td>
										<td class="px-4 pb-3 pt-4 sm:px-6"><p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ Str::limit($item->excerpt, 80, '...') }}</p></td>
									<td class="px-4 pb-3 pt-4 sm:px-6"><p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ optional($item->created_at)->format('Y-m-d H:i') }}</p></td>
										<td class="px-4 pb-3 pt-4 sm:px-6"><p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ optional($item->published_at)->format('Y-m-d H:i') ?? '—' }} - {{ ucfirst($item->status) }}</p></td>
										<td class="px-4 pb-3 pt-4 sm:px-6">
											<div class="flex items-center justify-end gap-2">
												<a href="{{ route('news.show', $item->slug) }}" class="flex items-center justify-center text-gray-500 hover:text-brand-500" title="View">
													<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
													</svg>
												</a>
												<a href="{{ route('staff.news.edit', $item) }}" class="flex items-center justify-center text-gray-500 hover:text-blue-600">
													<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
													</svg>
												</a>
												<form action="{{ route('staff.news.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this news item?');">
													@csrf
													@method('DELETE')
													<button type="submit" class="flex items-center justify-center text-gray-500 hover:text-error-600">
														<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
														</svg>
													</button>
												</form>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

				<div class="mt-5">{{ $items->links() }}</div>
			</div>
		</div>
	</div>
</x-staff.layout>
