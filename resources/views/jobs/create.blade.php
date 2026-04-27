<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; letter-spacing:-0.02em;">Add New Application</h2>
            <a href="{{ route('jobs.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#f1f5f9; color:#475569; padding:9px 16px; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none;">
                ← Back
            </a>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap');
        body { font-family: 'DM Sans', sans-serif; background: #f8f7ff; }
        .form-input { width:100%; border:1.5px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px; color:#0f172a; background:#f8fafc; transition:all 0.2s; box-sizing:border-box; font-family:'DM Sans',sans-serif; }
        .form-input:focus { outline:none; border-color:#6366f1; background:white; box-shadow:0 0 0 3px rgba(99,102,241,0.12); }
        .form-label { display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.06em; }
        .error-msg { color:#ef4444; font-size:12px; margin-top:4px; }
    </style>

    <div style="padding:32px 0;">
        <div style="max-width:760px; margin:0 auto; padding:0 24px;">

            <div style="background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:20px; padding:28px 32px; margin-bottom:24px; color:white;">
                <div style="font-family:'Sora',sans-serif; font-size:22px; font-weight:700; margin-bottom:6px;">Track a New Opportunity 🚀</div>
                <div style="opacity:0.8; font-size:14px;">Fill in the details below to add it to your tracker</div>
            </div>

            <div style="background:white; border-radius:20px; padding:32px; box-shadow:0 1px 3px rgba(0,0,0,0.06),0 8px 32px rgba(0,0,0,0.04);">
                <form method="POST" action="{{ route('jobs.store') }}">
                    @csrf
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                        <div>
                            <label class="form-label">Company *</label>
                            <input type="text" name="company" value="{{ old('company') }}" class="form-input" placeholder="e.g. Google">
                            @error('company')<p class="error-msg">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Role *</label>
                            <input type="text" name="role" value="{{ old('role') }}" class="form-input" placeholder="e.g. Laravel Developer">
                            @error('role')<p class="error-msg">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-input">
                                <option value="applied" {{ old('status')=='applied'?'selected':'' }}>🔵 Applied</option>
                                <option value="interview" {{ old('status')=='interview'?'selected':'' }}>🟡 Interview</option>
                                <option value="offer" {{ old('status')=='offer'?'selected':'' }}>🟢 Offer</option>
                                <option value="rejected" {{ old('status')=='rejected'?'selected':'' }}>🔴 Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Applied Date *</label>
                            <input type="date" name="applied_date" value="{{ old('applied_date', date('Y-m-d')) }}" class="form-input">
                            @error('applied_date')<p class="error-msg">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Location</label>
                            <input type="text" name="location" value="{{ old('location') }}" class="form-input" placeholder="e.g. Remote / Bangalore">
                        </div>
                        <div>
                            <label class="form-label">Expected Salary (₹)</label>
                            <input type="number" name="salary" value="{{ old('salary') }}" class="form-input" placeholder="e.g. 600000">
                        </div>
                    </div>
                    <div style="margin-bottom:20px;">
                        <label class="form-label">Job URL</label>
                        <input type="url" name="job_url" value="{{ old('job_url') }}" class="form-input" placeholder="https://...">
                        @error('job_url')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                    <div style="margin-bottom:28px;">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" rows="3" class="form-input" placeholder="Any notes about this application...">{{ old('notes') }}</textarea>
                    </div>
                    <div style="display:flex; justify-content:flex-end; gap:12px;">
                        <a href="{{ route('jobs.index') }}" style="background:#f1f5f9; color:#64748b; padding:11px 22px; border-radius:10px; font-size:14px; font-weight:600; text-decoration:none;">Cancel</a>
                        <button type="submit" style="background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; padding:11px 28px; border-radius:10px; font-size:14px; font-weight:600; border:none; cursor:pointer; box-shadow:0 4px 15px rgba(99,102,241,0.4);">
                            Save Application ✓
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>