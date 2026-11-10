import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Admin Log in | Pure Sip" />

            {/* Pure Sip Branding Header inside Card */}
            <div className="text-center mb-6">
                <h2 className="text-2xl font-black text-[#183928] tracking-tight">
                    Pure Sip Admin Hub
                </h2>
                <p className="text-xs text-gray-500 mt-1 font-medium">
                    Sign in to manage your botanical drinks & dashboard
                </p>
            </div>

            {status && (
                <div className="mb-4 text-sm font-medium text-emerald-600 bg-emerald-50 p-3 rounded-xl">
                    {status}
                </div>
            )}

            <form onSubmit={submit} className="space-y-4">
                <div>
                    <InputLabel htmlFor="email" value="Email Address" className="font-bold text-gray-700 text-xs uppercase tracking-wider" />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1.5 block w-full text-sm rounded-2xl border-gray-200 p-3.5 focus:border-[#183928] focus:ring-[#183928]"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                    />

                    <InputError message={errors.email} className="mt-2 text-xs" />
                </div>

                <div>
                    <InputLabel htmlFor="password" value="Password" className="font-bold text-gray-700 text-xs uppercase tracking-wider" />

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1.5 block w-full text-sm rounded-2xl border-gray-200 p-3.5 focus:border-[#183928] focus:ring-[#183928]"
                        autoComplete="current-password"
                        onChange={(e) => setData('password', e.target.value)}
                    />

                    <InputError message={errors.password} className="mt-2 text-xs" />
                </div>

                <div className="flex items-center justify-between pt-1">
                    <label className="flex items-center cursor-pointer">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) =>
                                setData('remember', e.target.checked)
                            }
                            className="rounded border-gray-300 text-[#183928] focus:ring-[#183928]"
                        />
                        <span className="ms-2 text-xs font-bold text-gray-600">
                            Remember me
                        </span>
                    </label>

                    {canResetPassword && (
                        <Link
                            href={route('password.request')}
                            className="text-xs font-bold text-[#183928] hover:underline focus:outline-none"
                        >
                            Forgot password?
                        </Link>
                    )}
                </div>

                <div className="pt-2">
                    <PrimaryButton 
                        className="w-full justify-center bg-[#183928] hover:bg-[#122c1f] focus:bg-[#122c1f] active:bg-[#122c1f] text-white text-sm font-bold py-3.5 rounded-2xl shadow-md transition-all cursor-pointer" 
                        disabled={processing}
                    >
                        Log in to Dashboard
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}