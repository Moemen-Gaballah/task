@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">transfer</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('transactions.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="user_id" class="col-md-4 col-form-label text-md-end">Choose User</label>

                                <div class="col-md-6">

                                    <select required id="user_id"
                                            class="form-select  @error('user_id') is-invalid @enderror " name="user_id"
                                            aria-label="Default select example">
                                        <option selected>Choose User</option>
                                        @foreach($users as $user)
                                            <option @if(old('user_id') == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">amount</label>

                                <div class="col-md-6">
                                    <input id="amount" type="number" max="200" value="{{old('amount')}}"
                                           class="form-control @error('amount') is-invalid @enderror" name="amount"
                                           required>

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Card Number</label>

                                <div class="col-md-6">
                                    <input id="card_number" type="text" value="{{old('card_number')}}"
                                           class="form-control @error('card_number') is-invalid @enderror"
                                           name="card_number"
                                           placeholder=".... .... .... ...."
                                           data-slots="." data-accept="\d" size="19"
                                           required>

                                    @error('card_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Name on card</label>

                                <div class="col-md-6">
                                    <input id="name_on_card" type="text" value="{{old('name_on_card')}}"
                                           class="form-control @error('name_on_card') is-invalid @enderror"
                                           name="name_on_card"
                                           placeholder="Mo'men Gaballah"
                                           required>

                                    @error('name_of_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Expiry Date</label>

                                <div class="col-md-6">
                                    <input id="expiry_date" type="text" value="{{old('expiry_date')}}"
                                           class="form-control @error('expiry_date') is-invalid @enderror"
                                           name="expiry_date"
                                           placeholder="mm/yyyy" data-slots="my"
                                           required>

                                    @error('expiry_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">CVV</label>

                                <div class="col-md-6">
                                    <input id="expiry_date" type="text" value="{{old('cvv')}}"
                                           class="form-control @error('cvv') is-invalid @enderror" name="cvv"
                                           placeholder="..." data-slots="."
                                           data-accept="\d" size="3"
                                           required>

                                    @error('cvv')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
                const pattern = el.getAttribute("placeholder"),
                    slots = new Set(el.dataset.slots || "_"),
                    prev = (j => Array.from(pattern, (c, i) => slots.has(c) ? j = i + 1 : j))(0),
                    first = [...pattern].findIndex(c => slots.has(c)),
                    accept = new RegExp(el.dataset.accept || "\\d", "g"),
                    clean = input => {
                        input = input.match(accept) || [];
                        return Array.from(pattern, c =>
                            input[0] === c || slots.has(c) ? input.shift() || c : c
                        );
                    },
                    format = () => {
                        const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                            i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                            return i < 0 ? prev[prev.length - 1] : back ? prev[i - 1] || first : i;
                        });
                        el.value = clean(el.value).join``;
                        el.setSelectionRange(i, j);
                        back = false;
                    };
                let back = false;
                el.addEventListener("keydown", (e) => back = e.key === "Backspace");
                el.addEventListener("input", format);
                el.addEventListener("focus", format);
                el.addEventListener("blur", () => el.value === pattern && (el.value = ""));
            }
        });
    </script>
@endsection
