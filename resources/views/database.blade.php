<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Database Visual</title>
	<style>
		:root {
			--bg: #f4f7fb;
			--card: #ffffff;
			--ink: #0f172a;
			--muted: #475569;
			--line: #dbe4ef;
			--head: #eaf1fb;
			--accent: #0f766e;
		}

		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			padding: 2rem;
			font-family: "Trebuchet MS", "Segoe UI", sans-serif;
			color: var(--ink);
			background: radial-gradient(circle at top right, #d7e8ff 0%, var(--bg) 55%);
		}

		.wrapper {
			max-width: 1200px;
			margin: 0 auto;
		}

		h1 {
			margin: 0 0 0.75rem;
			font-size: clamp(1.8rem, 2.5vw, 2.4rem);
		}

		.intro {
			margin: 0 0 1.5rem;
			color: var(--muted);
		}

		.cards {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
			gap: 1rem;
			margin-bottom: 1.5rem;
		}

		.card {
			background: var(--card);
			border: 1px solid var(--line);
			border-radius: 12px;
			padding: 0.9rem 1rem;
			box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
		}

		.card .name {
			margin: 0;
			color: var(--muted);
			font-size: 0.9rem;
		}

		.card .value {
			margin: 0.25rem 0 0;
			font-size: 1.4rem;
			font-weight: 700;
			color: var(--accent);
		}

		section {
			margin-bottom: 1.5rem;
			background: var(--card);
			border: 1px solid var(--line);
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
		}

		.section-title {
			margin: 0;
			padding: 0.85rem 1rem;
			font-size: 1.05rem;
			background: var(--head);
			border-bottom: 1px solid var(--line);
		}

		.table-wrap {
			overflow-x: auto;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			min-width: 720px;
		}

		th,
		td {
			text-align: left;
			padding: 0.65rem 0.8rem;
			border-bottom: 1px solid var(--line);
			vertical-align: top;
		}

		th {
			font-size: 0.85rem;
			letter-spacing: 0.03em;
			color: var(--muted);
			text-transform: uppercase;
			background: #f8fbff;
			position: sticky;
			top: 0;
		}

		tbody tr:hover {
			background: #f6fbff;
		}

		.empty {
			margin: 0;
			padding: 1rem;
			color: var(--muted);
			font-style: italic;
		}
	</style>
</head>
<body>
	<main class="wrapper">
		<h1>Database Overview</h1>
		<p class="intro">Visual snapshot of your seeded data by table.</p>

		<div class="cards">
			<article class="card"><p class="name">Products</p><p class="value">{{ $products->count() }}</p></article>
			<article class="card"><p class="name">Types</p><p class="value">{{ $types->count() }}</p></article>
			<article class="card"><p class="name">Grades</p><p class="value">{{ $grades->count() }}</p></article>
			<article class="card"><p class="name">Digitals</p><p class="value">{{ $digitals->count() }}</p></article>
			<article class="card"><p class="name">Users</p><p class="value">{{ $users->count() }}</p></article>
			<article class="card"><p class="name">Carts</p><p class="value">{{ $carts->count() }}</p></article>
			<article class="card"><p class="name">Cart Items</p><p class="value">{{ $cartItems->count() }}</p></article>
		</div>

		<section>
			<h2 class="section-title">Products</h2>
			@if ($products->isEmpty())
				<p class="empty">No products found.</p>
			@else
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Price</th>
								<th>Release</th>
								<th>Stock</th>
								<th>Type</th>
								<th>Grade</th>
								<th>Digital</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($products as $product)
								<tr>
									<td>{{ $product->id }}</td>
									<td>{{ $product->name }}</td>
									<td>${{ number_format($product->price, 2) }}</td>
									<td>{{ $product->release }}</td>
									<td>{{ $product->stock }}</td>
									<td>{{ $product->type?->name ?? '-' }}</td>
									<td>{{ $product->grade?->name ?? '-' }}</td>
									<td>{{ $product->digital?->name ?? '-' }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</section>

		<section>
			<h2 class="section-title">Types</h2>
			@if ($types->isEmpty())
				<p class="empty">No types found.</p>
			@else
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($types as $type)
								<tr>
									<td>{{ $type->id }}</td>
									<td>{{ $type->name }}</td>
									<td>{{ $type->description }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</section>

		<section>
			<h2 class="section-title">Grades</h2>
			@if ($grades->isEmpty())
				<p class="empty">No grades found.</p>
			@else
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($grades as $grade)
								<tr>
									<td>{{ $grade->id }}</td>
									<td>{{ $grade->name }}</td>
									<td>{{ $grade->description }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</section>

		<section>
			<h2 class="section-title">Digitals</h2>
			@if ($digitals->isEmpty())
				<p class="empty">No digital options found.</p>
			@else
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($digitals as $digital)
								<tr>
									<td>{{ $digital->id }}</td>
									<td>{{ $digital->name }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</section>

		<section>
			<h2 class="section-title">Users</h2>
			@if ($users->isEmpty())
				<p class="empty">No users found.</p>
			@else
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Created At</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
								<tr>
									<td>{{ $user->id }}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->created_at }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</section>

		<section>
			<h2 class="section-title">Carts</h2>
			@if ($carts->isEmpty())
				<p class="empty">No carts found.</p>
			@else
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>User ID</th>
								<th>Created At</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($carts as $cart)
								<tr>
									<td>{{ $cart->id }}</td>
									<td>{{ $cart->user_id }}</td>
									<td>{{ $cart->created_at }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</section>

		<section>
			<h2 class="section-title">Cart Items</h2>
			@if ($cartItems->isEmpty())
				<p class="empty">No cart items found.</p>
			@else
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Cart ID</th>
								<th>Product ID</th>
								<th>Amount</th>
								<th>Created At</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($cartItems as $item)
								<tr>
									<td>{{ $item->id }}</td>
									<td>{{ $item->cart_id }}</td>
									<td>{{ $item->product_id }}</td>
									<td>{{ $item->amount }}</td>
									<td>{{ $item->created_at }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</section>
	</main>
</body>
</html>
