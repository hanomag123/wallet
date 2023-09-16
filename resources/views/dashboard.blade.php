<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @foreach ($wallets as $wallet)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-2">
                        <h2 class="text-lg">Ваша карта:</h2>
                        <ul class="space-y-2 mt-4">
                            <li>Номер счета: {{ $wallet->id }}</li>
                            <li>Имя: {{ $user->name }}</li>
                            <li>email: {{ $user->email }}</li>
                        </ul>
                        <h3 class="text-lg mt-3">Остаток на счете: {{ $wallet->money }}</h3>

                        <div class="flex gap-4">
                          <form method="post" action="{{route('payment.get')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$wallet->id}}">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Пополнить на 5
                            </button>
                          </form>
                          <form method="post" action="{{route('payment.send')}}">
                            <input type="hidden" name="id" value="{{$wallet->id}}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Вывести 5
                            </button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Отправить на счет
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Введите данные для отправки денег на другой счет
                            </p>
                        </header>
                        <form method="post" action="{{ route('wallet.debit') }}" class="mt-6 space-y-6">
                            @csrf
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                    for="cardfrom">
                                    Номер счета с которого отправить
                                </label>
                                <input
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                                    id="cardfrom" name="cardfrom" type="number" required>
                                @error('cardfrom')
                                    <div class="alert alert-danger text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                    for="cardto">
                                    Номер счета на который отправить
                                </label>
                                <input
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                                    id="cardto" name="cardto" type="number" required>
                                @error('cardto')
                                    <div class="alert alert-danger text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                    for="sum">
                                    Сумма
                                </label>
                                <input
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                                    id="sum" name="sum" type="number" required>
                                @error('sum')
                                    <div class="alert alert-danger text-red-600">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="flex items-center gap-4">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Отправить
                                </button>

                                @if (session('success'))
                                    <div class="text-green-600">{{ session('success') }}</div>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
