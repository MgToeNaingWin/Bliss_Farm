@extends('admin.layouts.master')
@section('content')

<style>
    /* ================= DESIGN TOKENS ================= */
    #ranch-dashboard {
        --ink:       #1B211C;   /* near-black pine ink   */
        --forest:    #24402F;   /* primary brand green   */
        --forest-2:  #365A44;   /* secondary green        */
        --brass:     #B8863A;   /* aged brass / gold accent */
        --brass-2:   #D9A85C;   /* brighter brass hover   */
        --sage:      #93A692;   /* muted sage             */
        --rust:      #A5482F;   /* alert / removed        */
        --stone:     #F6F3EB;   /* page background        */
        --paper:     #FFFFFF;   /* card surface           */
        --line:      #E7E1D3;   /* hairline border        */
        --muted:     #7A7A6E;   /* secondary text         */
        font-family: 'Inter', -apple-system, sans-serif;
        background: var(--stone);
        color: var(--ink);
        min-height: 100%;
    }

    #ranch-dashboard .display {
        font-family: 'Fraunces', Georgia, serif;
        letter-spacing: -0.01em;
    }

    #ranch-dashboard .mono {
        font-family: 'IBM Plex Mono', ui-monospace, monospace;
    }

    /* ---------- layout shell ---------- */
    .rd-wrap { padding: 28px 32px 60px; max-width: 1400px; margin: 0 auto; }

    /* ---------- top bar ---------- */
    .rd-topbar {
        display: flex; align-items: center; justify-content: space-between;
        gap: 20px; flex-wrap: wrap;
        padding-bottom: 24px; margin-bottom: 32px;
        border-bottom: 1px solid var(--line);
    }
    .rd-crumb { font-size: 12px; text-transform: uppercase; letter-spacing: .12em; color: var(--sage); margin-bottom: 6px; }
    .rd-crumb span { color: var(--muted); }
    .rd-title { font-size: 26px; font-weight: 600; color: var(--forest); }

    .rd-actions { display: flex; align-items: center; gap: 10px; }
    .rd-search { position: relative; width: 220px; }
    .rd-search input {
        width: 100%; height: 40px; border-radius: 10px;
        border: 1px solid var(--line); background: var(--paper);
        padding: 0 14px 0 36px; font-size: 13.5px; color: var(--ink);
        outline: none; transition: border-color .15s, box-shadow .15s;
    }
    .rd-search input:focus { border-color: var(--brass); box-shadow: 0 0 0 3px rgba(184,134,58,.15); }
    .rd-search svg { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: var(--muted); }

    .rd-iconbtn {
        width: 40px; height: 40px; border-radius: 10px;
        display: grid; place-items: center;
        background: var(--paper); border: 1px solid var(--line);
        color: var(--forest); cursor: pointer; transition: all .15s;
    }
    .rd-iconbtn:hover { background: var(--forest); color: var(--paper); border-color: var(--forest); }
    .rd-iconbtn svg { width: 18px; height: 18px; }

    .rd-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: linear-gradient(135deg, var(--brass), var(--forest));
        display: grid; place-items: center; color: #fff; font-size: 13px; font-weight: 700;
        border: 2px solid var(--paper); box-shadow: 0 0 0 1px var(--line); cursor: pointer;
    }

    /* ---------- stat cards ---------- */
    .rd-stats {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;
    }
    @media (max-width: 1100px) { .rd-stats { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 620px)  { .rd-stats { grid-template-columns: 1fr; } }

    .rd-stat {
        background: var(--paper); border: 1px solid var(--line); border-radius: 16px;
        padding: 22px 22px 18px; position: relative; overflow: hidden;
        transition: transform .18s ease, box-shadow .18s ease;
    }
    .rd-stat:hover { transform: translateY(-3px); box-shadow: 0 14px 30px -14px rgba(27,33,28,.25); }
    .rd-stat::before {
        content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
        background: var(--accent, var(--brass));
    }
    .rd-stat-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 18px; }
    .rd-stat-icon {
        width: 42px; height: 42px; border-radius: 11px;
        display: grid; place-items: center; color: #fff;
        background: var(--accent, var(--brass));
    }
    .rd-stat-icon svg { width: 21px; height: 21px; }
    .rd-stat-label { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); font-weight: 600; }
    .rd-stat-value { font-size: 30px; font-weight: 600; color: var(--ink); margin-top: 2px; }
    .rd-stat-trend { font-size: 12.5px; color: var(--muted); padding-top: 14px; border-top: 1px solid var(--line); margin-top: 4px; }
    .rd-stat-trend b.up { color: #3F7A4E; }
    .rd-stat-trend b.down { color: var(--rust); }

    /* ---------- table card ---------- */
    .rd-panel {
        background: var(--paper); border: 1px solid var(--line); border-radius: 18px;
        overflow: hidden;
    }
    .rd-panel-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 24px 26px 18px;
    }
    .rd-panel-eyebrow { font-size: 11.5px; text-transform: uppercase; letter-spacing: .12em; color: var(--brass); font-weight: 700; margin-bottom: 4px; }
    .rd-panel-title { font-size: 19px; font-weight: 600; color: var(--forest); }
    .rd-panel-sub { font-size: 12.5px; color: var(--muted); margin-top: 3px; }

    .rd-table-scroll { overflow-x: auto; }
    table.rd-table { width: 100%; border-collapse: collapse; min-width: 780px; }
    table.rd-table thead th {
        text-align: left; font-size: 10.5px; text-transform: uppercase; letter-spacing: .1em;
        color: var(--muted); font-weight: 700; padding: 10px 26px; background: var(--stone);
        border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);
    }
    table.rd-table tbody td { padding: 16px 26px; border-bottom: 1px solid var(--line); vertical-align: middle; }
    table.rd-table tbody tr { transition: background .12s; }
    table.rd-table tbody tr:hover { background: #FBF9F3; }
    table.rd-table tbody tr:last-child td { border-bottom: none; }

    .rd-listing-name { font-weight: 600; font-size: 14px; color: var(--ink); }
    .rd-listing-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }
    .rd-thumb { width: 64px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid var(--line); }
    .rd-desc { font-size: 12.5px; color: var(--muted); max-width: 320px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .rd-btn {
        border: none; cursor: pointer; font-size: 12px; font-weight: 700;
        padding: 8px 16px; border-radius: 8px; letter-spacing: .02em; transition: opacity .15s;
    }
    .rd-btn:hover { opacity: .85; }
    .rd-btn.danger  { background: #F7E6E0; color: var(--rust); }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

<div id="ranch-dashboard">
    <div class="rd-wrap">

        <!-- ============ TOP BAR ============ -->
        <div class="rd-topbar">
            <div>
                <div class="rd-crumb">Dashboard <span>/ Home</span></div>
                <h1 class="rd-title display">Ranch Overview</h1>
            </div>

            <div class="rd-actions">
                <div class="rd-search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                    <input type="text" placeholder="Search listings…">
                </div>

                <div class="rd-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                </div>
            </div>
        </div>

        <!-- Notification Success Message -->
        @if(session('success'))
            <div style="padding: 12px 20px; background-color: #E9F2E8; color: #33693F; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- ============ STAT CARDS ============ -->
        <div class="rd-stats">

            <!-- 1. Disease & News Count -->
            <div class="rd-stat" style="--accent:#B8863A">
                <div class="rd-stat-top">
                    <div>
                        <div class="rd-stat-label">ရောဂါနှင့် သတင်းများ</div>
                        <div class="rd-stat-value display">{{ $totalNewsAndDisease }}</div>
                    </div>
                    <div class="rd-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="rd-stat-trend">သတင်းများနှင့် ရောဂါအချက်အလက် စုစုပေါင်း</div>
            </div>

            <!-- 2. Livestock Posts Count -->
            <div class="rd-stat" style="--accent:#24402F">
                <div class="rd-stat-top">
                    <div>
                        <div class="rd-stat-label">မွေးမြူရေးနှင့် ပို့စ်များ</div>
                        <div class="rd-stat-value display">{{ $postsCount }}</div>
                    </div>
                    <div class="rd-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M8.25 9V8.25A2.25 2.25 0 0110.5 6h3a2.25 2.25 0 012.25 2.25V9m-9.75 0h.75m-1.5 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                        </svg>
                    </div>
                </div>
                <div class="rd-stat-trend">သုံးစွဲသူများ တင်ထားသော ပို့စ်များ</div>
            </div>

            <!-- 3. Clients Count -->
            <div class="rd-stat" style="--accent:#93A692">
                <div class="rd-stat-top">
                    <div>
                        <div class="rd-stat-label">ဝယ်ယူသူ/သုံးစွဲသူများ</div>
                        <div class="rd-stat-value display">{{ $clientsCount }}</div>
                    </div>
                    <div class="rd-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                        </svg>
                    </div>
                </div>
                <div class="rd-stat-trend">အကောင့်ဖွင့်ထားသော စုစုပေါင်း အသုံးပြုသူ</div>
            </div>

            <!-- 4. Default Sales -->
            <div class="rd-stat" style="--accent:#A5482F">
                <div class="rd-stat-top">
                    <div>
                        <div class="rd-stat-label">အရောင်းပမာဏ</div>
                        <div class="rd-stat-value display">{{ $totalSales }}</div>
                    </div>
                    <div class="rd-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z" />
                        </svg>
                    </div>
                </div>
                <div class="rd-stat-trend"><b class="up">+၅%</b> မနေ့ကထက် တိုးတက်မှု</div>
            </div>

        </div>

        <!-- ============ LISTINGS TABLE ============ -->
        <div class="rd-panel">
            <div class="rd-panel-head">
                <div>
                    <div class="rd-panel-eyebrow">Manage Listings</div>
                    <div class="rd-panel-title display">Livestock For Sale &amp; Posts</div>
                    <div class="rd-panel-sub">သုံးစွဲသူများမှ တင်ထားသော ရောင်းရန် ပို့စ်များ စာရင်း</div>
                </div>
            </div>

            <div class="rd-table-scroll">
                <table class="rd-table">
                    <thead>
                        <tr>
                            <th>Seller</th>
                            <th>Photo</th>
                            <th>Listing Title</th>
                            <th>Price &amp; Location</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sellPosts as $post)
                            <tr>
                                <td>
                                    <div class="rd-listing-name">{{ $post->user->name ?? 'Unknown User' }}</div>
                                    <div class="rd-listing-sub mono">{{ $post->phone }}</div>
                                </td>
                                <td>
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" class="rd-thumb" alt="Listing photo">
                                    @else
                                        <img src="{{ asset('masterImages/cows-green-field.avif') }}" class="rd-thumb" alt="Default photo">
                                    @endif
                                </td>
                                <td>
                                    <div class="rd-listing-name" style="font-weight:500;">{{ $post->title }}</div>
                                    <div class="rd-listing-sub">{{ $post->category }}</div>
                                </td>
                                <td>
                                    <div class="rd-listing-name" style="color: var(--forest);">{{ number_format($post->price) }} MMK</div>
                                    <div class="rd-listing-sub">{{ $post->location }}</div>
                                </td>
                                <td>
                                    <p class="rd-desc">{{ $post->description }}</p>
                                </td>
                                <td>
                                    <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" onsubmit="return confirm('ဒီ ပို့စ်ကို ဖျက်မှာ သေချာပါသလား?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rd-btn danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--muted); padding: 30px;">
                                    မည်သည့် ပို့စ်မျှ မရှိသေးပါ။
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection

