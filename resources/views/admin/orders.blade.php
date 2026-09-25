@extends('dashboard.layouts.app')

@section('title', 'Orders')

@section('content')
@php
    $user = Auth::user();
    $statusMap = [
        0 => ['Pending', 'amber'],
        1 => ['Available', 'blue'],
        2 => ['Assigned', 'violet'],
        3 => ['Editing', 'blue'],
        4 => ['Completed', 'green'],
        5 => ['Approved', 'green'],
        6 => ['Revision', 'amber'],
        7 => ['Cancelled', 'rose'],
        8 => ['Editor Revision', 'violet'],
        9 => ['Dispute', 'rose'],
    ];
    $isAdminish = $user->is_admin() || $user->is_subadmin();
@endphp

@include('dashboard.partials.flash')

<header class="rsd-page-head">
    <div>
        <span class="rsd-eyebrow">Orders Desk</span>
        <h1>{{ !empty($title) ? $title : 'Recent Orders' }}</h1>
        <p>Search, filter and manage customer orders.</p>
    </div>
    <a class="rsd-btn primary" href="{{ route('add_order') }}"><i class="fa fa-plus"></i> New Order</a>
</header>

<section class="rsd-panel">
    <div class="rsd-table-wrap">
        <table class="rsd-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order</th>
                    <th>Service</th>
                    @if ($isAdminish)<th>Customer</th>@endif
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    @php $s = $statusMap[$order->status] ?? ['Unknown', 'slate']; @endphp
                    <tr>
                        <td data-label="ID" class="rsd-cell-main">#{{ $order->id }}</td>
                        <td data-label="Order">
                            <a class="rsd-cell-main" href="{{ route('view_order', $order->slug) }}">{{ \Illuminate\Support\Str::limit($order->title, 42) }}</a>
                            <span class="rsd-cell-sub">
                                @if ($user->is_client() || $isAdminish || $user->is_student())
                                    {!! remainingtime($order->order_due) !!}
                                @elseif ($user->is_writer())
                                    {!! remainingtime($order->order_wrdeadline) !!}
                                @elseif ($user->is_editor())
                                    {!! remainingtime($order->order_eddeadline) !!}
                                @endif
                            </span>
                        </td>
                        <td data-label="Service" class="muted">
                            {{ subject($order->category_id) }}
                            @if ($order->word_count)
                                <span class="rsd-cell-sub">{{ $order->word_count }} {{ $order->word_count == 1 ? 'page' : 'pages' }} ({{ $order->word_count * 275 }} words)</span>
                            @endif
                        </td>
                        @if ($isAdminish)
                            <td data-label="Customer">
                                <a class="rsd-cell-main" href="{{ route('user_info', $order->user_id) }}">{{ username($order->user_id)->name ?? 'none' }}</a>
                                @if ($order->writer_id)
                                    <span class="rsd-cell-sub">Writer: {{ username($order->writer_id)->name ?? 'none' }}</span>
                                @endif
                                @if ($order->editor_id)
                                    <span class="rsd-cell-sub">Editor: {{ username($order->editor_id)->name ?? 'none' }}</span>
                                @endif
                            </td>
                        @endif
                        <td data-label="Amount" class="nowrap">
                            @if ($user->is_editor())
                                {{ price((int) $order->ecost) }}
                            @elseif ($user->is_writer())
                                {{ price((int) $order->wcost) }}
                            @else
                                @if ($order->order_level == 'technical' && $order->ccost <= 0)
                                    {{ price((int) $order->order_budget) }}
                                @else
                                    {{ price((int) $order->ccost) }}
                                @endif
                                @if ($isAdminish)
                                    <span class="rsd-cell-sub">{{ $order->payment_way == 0 ? 'Pre pay' : 'Pay later' }}</span>
                                @endif
                            @endif
                        </td>
                        <td data-label="Status">
                            <span class="rsd-pill {{ $s[1] }}">{{ $s[0] }}</span>
                            @if ($order->status == 0 || $order->status == 1)
                                @if ($isAdminish || $user->is_editor() || $user->view_bids == 'YES')
                                    @if (!$user->is_writer())
                                        @php $bid_count = \App\Models\Bid::whereOrderId($order->id)->count(); @endphp
                                        <a class="rsd-cell-sub" href="{{ route('view_bids', $order->id) }}">bids ({{ $bid_count }})</a>
                                    @endif
                                @endif
                            @endif
                        </td>
                        <td data-label="Date" class="nowrap muted">{{ optional($order->created_at)->format('d M Y') }}</td>
                        <td data-label="Actions">
                            <div class="rsd-actions">
                                @php $chats_count = \App\Models\Chat::whereOrderId($order->id)->count(); @endphp
                                <a class="rsd-action" href="{{ route('view_order', $order->slug) }}/#chat" title="Chat ({{ $chats_count }})"><i class="fa fa-comments"></i></a>

                                @if ($isAdminish && $order->status != 0)
                                    <a class="rsd-action" href="{{ route('edit_order', $order->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                @elseif (!$user->is_writer() && ($order->status == 0 || $order->status == 7))
                                    <a class="rsd-action" href="{{ route('edit_order', $order->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                @endif

                                @if (($user->is_client() || $user->is_student()) && ($order->status == 0 || $order->payment_way == 1) && $order->ccost > 0)
                                    <a class="rsd-action" style="width:auto; padding: 0 12px; color:#047857;" data-bs-toggle="modal" data-bs-target="#confirm-order{{ $order->id }}" title="Pay Now"><i class="fa fa-check"></i> Pay</a>
                                @endif

                                @if ($user->is_editor() && !$order->editor_id && $order->ecost > 0 && $order->status == 3)
                                    <a class="rsd-action" style="width:auto; padding: 0 12px; color:#b45309;" data-bs-toggle="modal" data-bs-target="#pick{{ $order->id }}" title="Pick Order"><i class="fa fa-check"></i> Pick</a>
                                @endif

                                @if ($isAdminish)
                                    <a class="rsd-action danger" data-bs-toggle="modal" data-bs-target="#delete-order{{ $order->id }}" title="Delete"><i class="fa fa-trash"></i></a>
                                    <a class="rsd-action" data-bs-toggle="modal" data-bs-target="#cancel-order{{ $order->id }}" title="Cancel"><i class="fa fa-ban"></i></a>
                                @endif

                                @if (!$user->is_writer())
                                    <a class="rsd-action" data-bs-toggle="modal" data-bs-target="#duplicate-order{{ $order->id }}" title="Duplicate"><i class="fa fa-copy"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="rsd-empty">No order available</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if (method_exists($orders, 'links'))
        <div class="rsd-pagination">{!! $orders->links('pagination::bootstrap-4') !!}</div>
    @endif
</section>

{{-- Modals for each order --}}
@foreach ($orders as $order)
    {{-- Pick order (editor) --}}
    @if ($user->is_editor() && !$order->editor_id && $order->ecost > 0 && $order->status == 3)
        <div class="modal fade" id="pick{{ $order->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 50px rgba(16,24,40,.2);">
                    <div class="modal-header"><h6 class="modal-title">Pick order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                    <div class="modal-body">
                        <form action="{{ route('epick_order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <p>Are you sure you want to pick this order?</p>
                            @if ($order->order_level == 'technical')
                                <div class="rsd-form-group">
                                    <label>My Budget ({{ get_currency() }})</label>
                                    <input type="number" class="rsd-form-control" name="writer_budget" value="0">
                                </div>
                            @endif
                            <button type="submit" class="rsd-btn primary">Yes, Proceed</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Pay now (client) --}}
    @if (($user->is_client() || $user->is_student()) && ($order->status == 0 || $order->payment_way == 1) && $order->ccost > 0)
        <div class="modal fade" id="confirm-order{{ $order->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 50px rgba(16,24,40,.2);">
                    <div class="modal-header"><h6 class="modal-title">Confirm order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                    <div class="modal-body">
                        <form action="{{ route('confirm_order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <div class="rsd-form-group"><label>Title</label><input type="text" class="rsd-form-control" value="{{ $order->title }}" disabled></div>
                            <div class="rsd-form-group"><label>Amount ({{ get_currency() }})</label><input type="text" class="rsd-form-control" value="{{ $order->ccost }}" disabled></div>
                            @if ($order->urgency_id)
                                @php $pricing = \App\Models\Pricing::find($order->urgency_id); @endphp
                                @if ($pricing && $order->word_count <= $pricing->max_page)
                                    @if (wallet($user->id) < $order->ccost)
                                        <button type="submit" class="rsd-btn primary">Pay {{ get_currency() }} {{ $order->ccost - wallet($user->id) }}</button>
                                    @else
                                        <button type="submit" class="rsd-btn primary">Submit</button>
                                    @endif
                                @else
                                    <div class="rsd-alert warning">We cannot deliver within the specified deadline. Please adjust it.</div>
                                    <a href="{{ route('edit_order', $order->id) }}" class="rsd-btn secondary">Edit</a>
                                    <button type="submit" class="rsd-btn primary">Just Work On It</button>
                                @endif
                            @else
                                <div class="rsd-alert warning">We cannot deliver within the specified deadline. Please adjust it.</div>
                                <button type="submit" class="rsd-btn primary">Just Work On It</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete order --}}
    @if ($isAdminish)
        <div class="modal fade" id="delete-order{{ $order->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 50px rgba(16,24,40,.2);">
                    <div class="modal-header"><h6 class="modal-title">Delete #{{ $order->id }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                    <div class="modal-body">
                        <form action="{{ route('delete_order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <p>Are you sure you want to delete this order?</p>
                            <button type="submit" class="rsd-btn danger">Yes, Proceed</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Cancel order (admin) --}}
    @if ($isAdminish)
        <div class="modal fade" id="cancel-order{{ $order->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 50px rgba(16,24,40,.2);">
                    <div class="modal-header"><h6 class="modal-title">Cancel #{{ $order->id }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                    <div class="modal-body">
                        <form action="{{ route('acancel_order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <p>Are you sure you want to cancel this order?</p>
                            <button type="submit" class="rsd-btn danger">Yes, Proceed</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Duplicate order --}}
    @if (!$user->is_writer())
        <div class="modal fade" id="duplicate-order{{ $order->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 50px rgba(16,24,40,.2);">
                    <div class="modal-header"><h6 class="modal-title">Duplicate #{{ $order->id }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                    <div class="modal-body">
                        <form action="{{ route('duplicate_order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <p>Are you sure you want to duplicate this order?</p>
                            <button type="submit" class="rsd-btn primary">Yes, Proceed</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@if (!empty($show_inquiry) && $show_inquiry == '1')
    @php
        $torders = \App\Models\Order::whereOrderLevel('technical')->whereStatus(0)->orderBy('id', 'desc')->paginate(50);
        if ($user->added_by == 'client') {
            $torders = \App\Models\Order::whereOrderLevel('technical')->whereStatus(0)->whereUserId($user->user_id)->orderBy('id', 'desc')->paginate(50);
        }
    @endphp

    <section class="rsd-panel">
        <div class="rsd-panel__head">
            <div>
                <p class="rsd-eyebrow">Technical Inquiries</p>
                <h2>Available Technical Orders</h2>
            </div>
        </div>
        <div class="rsd-table-wrap">
            <table class="rsd-table">
                <thead>
                    <tr><th>ID</th><th>Order</th><th>Service</th><th>Amount</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($torders as $order)
                        @php $s = $statusMap[$order->status] ?? ['Unknown', 'slate']; @endphp
                        <tr>
                            <td data-label="ID" class="rsd-cell-main">#{{ $order->id }}</td>
                            <td data-label="Order">
                                <a class="rsd-cell-main" href="{{ route('view_order', $order->slug) }}">{{ \Illuminate\Support\Str::limit($order->title, 42) }}</a>
                                <span class="rsd-cell-sub">{!! remainingtime($order->order_wrdeadline) !!}</span>
                            </td>
                            <td data-label="Service" class="muted">{{ subject($order->category_id) }}</td>
                            <td data-label="Amount" class="nowrap">
                                @if ($order->wcost < 1) Inquiry @else {{ price((int) $order->wcost) }} @endif
                            </td>
                            <td data-label="Status"><span class="rsd-pill {{ $s[1] }}">{{ $s[0] }}</span></td>
                            <td data-label="Actions">
                                <div class="rsd-actions">
                                    <a class="rsd-action" href="{{ route('view_order', $order->slug) }}" title="View"><i class="fa fa-eye"></i></a>
                                    @if (!$user->is_writer())
                                        <a class="rsd-action" href="{{ route('edit_order', $order->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="rsd-empty">No order inquiry requested</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endif
@endsection
