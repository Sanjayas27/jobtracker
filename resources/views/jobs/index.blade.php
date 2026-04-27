<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; letter-spacing:-0.02em;">
                Job Applications
            </h2>
            <a href="{{ route('jobs.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; padding:10px 20px; border-radius:12px; font-size:13px; font-weight:600; text-decoration:none; box-shadow:0 4px 15px rgba(99,102,241,0.4);">
                + Add Application
            </a>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:wght@400;500&display=swap');
        body { font-family: 'DM Sans', sans-serif; background: #f8f7ff; }
        .stat-card { background:white; border-radius:16px; padding:20px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.04); transition:transform 0.2s,box-shadow 0.2s; }
        .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.1); }
        .stat-number { font-family:'Sora',sans-serif; font-size:2rem; font-weight:700; line-height:1; }
        .stat-label { font-size:12px; font-weight:500; color:#94a3b8; margin-top:6px; text-transform:uppercase; letter-spacing:0.08em; }
        .badge { display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; }
        .badge-applied { background:#eff6ff; color:#3b82f6; }
        .badge-interview { background:#fefce8; color:#ca8a04; }
        .badge-offer { background:#f0fdf4; color:#16a34a; }
        .badge-rejected { background:#fef2f2; color:#dc2626; }
        .badge::before { content:'●'; font-size:8px; }
        .action-btn { padding:5px 12px; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; border:none; cursor:pointer; transition:all 0.15s; }
        .btn-edit { background:#eff6ff; color:#3b82f6; }
        .btn-edit:hover { background:#3b82f6; color:white; }
        .btn-delete { background:#fef2f2; color:#dc2626; }
        .btn-delete:hover { background:#dc2626; color:white; }
    </style>

    <div style="padding:32px 0;">
        <div style="max-width:1200px; margin:0 auto; padding:0 24px;">

            @if(session('success'))
            <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1px solid #86efac; color:#15803d; padding:14px 18px; border-radius:12px; margin-bottom:24px; font-size:14px; font-weight:500;">
                ✓ {{ session('success') }}
            </div>
            @endif

            <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:16px; margin-bottom:28px;">
                <div class="stat-card" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                    <div class="stat-number" style="color:white;">{{ $stats['total'] }}</div>
                    <div class="stat-label" style="color:rgba(255,255,255,0.7);">Total</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color:#3b82f6;">{{ $stats['applied'] }}</div>
                    <div class="stat-label">Applied</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color:#f59e0b;">{{ $stats['interview'] }}</div>
                    <div class="stat-label">Interview</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color:#10b981;">{{ $stats['offer'] }}</div>
                    <div class="stat-label">Offer</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color:#ef4444;">{{ $stats['rejected'] }}</div>
                    <div class="stat-label">Rejected</div>
                </div>
            </div>

            <div style="background:white; border-radius:16px; padding:16px 20px; margin-bottom:20px; box-shadow:0 1px 3px rgba(0,0,0,0.06);">
                <form method="GET" action="{{ route('jobs.index') }}" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="🔍  Search company or role..."
                        style="flex:1; min-width:200px; border:1.5px solid #e2e8f0; border-radius:10px; padding:9px 14px; font-size:13px; color:#0f172a; background:#f8fafc; box-sizing:border-box;">
                    <select name="status" style="border:1.5px solid #e2e8f0; border-radius:10px; padding:9px 14px; font-size:13px; color:#0f172a; background:#f8fafc; cursor:pointer;">
                        <option value="">All Statuses</option>
                        <option value="applied" {{ request('status')=='applied'?'selected':'' }}>Applied</option>
                        <option value="interview" {{ request('status')=='interview'?'selected':'' }}>Interview</option>
                        <option value="offer" {{ request('status')=='offer'?'selected':'' }}>Offer</option>
                        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
                    </select>
                    <button type="submit" style="background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; padding:9px 20px; border-radius:10px; font-size:13px; font-weight:600; border:none; cursor:pointer;">Filter</button>
                    <a href="{{ route('jobs.index') }}" style="background:#f1f5f9; color:#64748b; padding:9px 16px; border-radius:10px; font-size:13px; font-weight:500; text-decoration:none;">Reset</a>
                </form>
            </div>

            <div style="background:white; border-radius:20px; box-shadow:0 1px 3px rgba(0,0,0,0.06),0 8px 32px rgba(0,0,0,0.04); overflow:hidden;">
                @if($applications->count())
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:linear-gradient(to right,#f8f7ff,#f0f0ff); border-bottom:1px solid #e8e8f0;">
                            <th style="padding:14px 24px; text-align:left; font-size:11px; font-weight:700; color:#6366f1; text-transform:uppercase; letter-spacing:0.1em;">Company</th>
                            <th style="padding:14px 20px; text-align:left; font-size:11px; font-weight:700; color:#6366f1; text-transform:uppercase; letter-spacing:0.1em;">Role</th>
                            <th style="padding:14px 20px; text-align:left; font-size:11px; font-weight:700; color:#6366f1; text-transform:uppercase; letter-spacing:0.1em;">Status</th>
                            <th style="padding:14px 20px; text-align:left; font-size:11px; font-weight:700; color:#6366f1; text-transform:uppercase; letter-spacing:0.1em;">Location</th>
                            <th style="padding:14px 20px; text-align:left; font-size:11px; font-weight:700; color:#6366f1; text-transform:uppercase; letter-spacing:0.1em;">Applied Date</th>
                            <th style="padding:14px 24px; text-align:right; font-size:11px; font-weight:700; color:#6366f1; text-transform:uppercase; letter-spacing:0.1em;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:16px 24px;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#6366f1,#8b5cf6); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:14px; flex-shrink:0;">
                                        {{ strtoupper(substr($app->company, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600; color:#0f172a; font-size:14px;">{{ $app->company }}</div>
                                        @if($app->job_url)
                                        <a href="{{ $app->job_url }}" target="_blank" style="font-size:11px; color:#6366f1; text-decoration:none;">View posting ↗</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="padding:16px 20px; color:#475569; font-size:14px; font-weight:500;">{{ $app->role }}</td>
                            <td style="padding:16px 20px;">
                                @php $badges = ['applied'=>'badge-applied','interview'=>'badge-interview','offer'=>'badge-offer','rejected'=>'badge-rejected']; @endphp
                                <span class="badge {{ $badges[$app->status] }}">{{ ucfirst($app->status) }}</span>
                            </td>
                            <td style="padding:16px 20px; color:#64748b; font-size:13px;">{{ $app->location ?? '—' }}</td>
                            <td style="padding:16px 20px; color:#64748b; font-size:13px;">{{ \Carbon\Carbon::parse($app->applied_date)->format('M d, Y') }}</td>
                            <td style="padding:16px 24px;">
                                <div style="display:flex; gap:8px; justify-content:flex-end;">
                                    <a href="{{ route('jobs.edit', $app) }}" class="action-btn btn-edit">Edit</a>
                                    <form method="POST" action="{{ route('jobs.destroy', $app) }}" style="display:inline;" onsubmit="return confirm('Delete this application?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding:16px 24px; border-top:1px solid #f1f5f9;">{{ $applications->links() }}</div>
                @else
                <div style="text-align:center; padding:80px 24px;">
                    <div style="font-size:48px; margin-bottom:16px;">📋</div>
                    <div style="font-size:18px; font-weight:700; color:#0f172a; margin-bottom:8px;">No applications yet</div>
                    <div style="font-size:14px; color:#94a3b8; margin-bottom:24px;">Start tracking your job hunt!</div>
                    <a href="{{ route('jobs.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; padding:12px 24px; border-radius:12px; font-size:14px; font-weight:600; text-decoration:none;">
                        + Add Your First Application
                    </a>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>