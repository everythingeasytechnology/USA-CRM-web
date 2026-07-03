<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In | EverythingEasy Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-100 selection:bg-blue-500/30 selection:text-blue-200">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-radial-gradient">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm text-center">
            <!-- Brand Logo / Name -->
            <div class="inline-flex h-10 items-center justify-center rounded-xl bg-blue-600 px-4 text-sm font-bold tracking-tight text-white shadow-lg shadow-blue-500/20">
                EverythingEasy
            </div>
            <h2 class="mt-8 text-xl font-bold tracking-tight text-white">Sign in to Admin Console</h2>
            <p class="mt-1 text-xs text-slate-400">Enter your credentials to manage services and SEO settings.</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-xl shadow-black/40">
                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-900 bg-red-950/40 px-3.5 py-2.5 text-xs text-red-300">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="space-y-5" action="/admin/login" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Email address</label>
                        <div class="mt-2">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                value="{{ old('email') }}"
                                class="block w-full rounded-lg border border-slate-800 bg-slate-950 px-3.5 py-2 text-sm text-white placeholder:text-slate-650 focus:outline-hidden focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Password</label>
                            <div class="text-xs">
                                <a href="#" class="font-medium text-blue-500 hover:text-blue-400 text-3xs uppercase tracking-wide">Forgot password?</a>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="block w-full rounded-lg border border-slate-800 bg-slate-950 px-3.5 py-2 text-sm text-white placeholder:text-slate-650 focus:outline-hidden focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" value="1" checked class="h-4 w-4 rounded-sm border-slate-800 bg-slate-950 text-blue-600 focus:ring-blue-500">
                            <label for="remember-me" class="ml-2 block text-2xs text-slate-400">Remember session</label>
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="flex w-full justify-center rounded-lg bg-blue-600 px-3.5 py-2.5 text-xs font-semibold text-white shadow-xs hover:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-colors"
                        >
                            Sign In to Dashboard
                        </button>
                    </div>
                </form>
            </div>
            
            <p class="mt-6 text-center text-3xs text-slate-500 uppercase tracking-wider">
                Authorized access only. Log files are actively audited.
            </p>
        </div>
    </div>
</body>
</html>
