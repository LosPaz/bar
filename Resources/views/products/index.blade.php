@extends('Bar::layouts.bar')

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            Prodotti
        </h1>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row row-cards">
                @foreach($products as $product)
                    <div class="col" style="max-width: 300px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><a href="javascript:void(0)">{{ $product->item->name }}</a></h4>
                                <div class="card-subtitle">
                                    Disponibilità
                                    <br />
                                    @foreach($product->getRepositoryTotal() as $repos)
                                        {{ $repos['name'] }}: {{$repos['total']}}
                                        <br />
                                    @endforeach
                                </div>
                                <div class="mt-5 d-flex align-items-center">
                                    <div class="product-price">
                                        <strong>&euro;{{ $product->client_price }}</strong>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="javascript:void(0)" class="btn btn-primary addItem"
                                           data-id="{{$product->id}}" data-name="{{$product->item->name}}"
                                           data-price="{{$product->client_price}}">
                                            <i class="fe fe-plus"></i> Aggiungi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cassa</h3>
                    @if(\Modules\Bar\Models\Workshift::mustBeClosed())
                        <div class="card-options">
                            <a href="javascript:void(0)"
                               data-status="close"
                               class="btn btn-primary float-right right ml-1 workshiftChange">CHIUDI TURNO</a>
                        </div>
                    @endif
                </div>
                @if(\Modules\Bar\Models\Workshift::mustBeClosed())
                    <div class="card-body">
                        <div class="dimmer" id="loader">
                            <div class="loader"></div>
                            <div class="dimmer-content">
                                <div class="m-1" id="cart">
                                    <table class="table card-table" id="cart-list">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card-footer">
                    @if(\Modules\Bar\Models\Workshift::mustBeOpened())
                        <div class="row text-center">
                            <div class="col-md-12 text-center">
                                <h3>Totale stimato in cassa: &euro;@if($estimatedAmount != null && $estimatedAmount->estimate_amount != null)
                                        {{ \Modules\Bar\Models\Workshift::getLastEstimatedAmount()->estimate_amount }}
                                    @else
                                        0
                                    @endif
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <a href="javascript:void(0)"
                               data-status="open"
                               class="btn btn-block btn-warning workshiftChange">APRI TURNO</a>
                        </div>
                    @else
                        <div class="row text-center mb-2">
                            <div class="col-md-12">
                                <h3 style="display: inline;">Totale &euro;</h3>
                                <h3 style="display: inline;" id="totalPrice">0</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 btn-group">
                                <a href="javascript:void(0)" class="btn btn-outline-success send w-100">APPLICA</a>
                                <a href="javascript:void(0)" class="btn btn-outline-warning empty w-100">SVUOTA</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        class Item {

            constructor(id, name, qty, price){
                this.id = id;
                this.name = name;
                this.qty = qty;
                this.price = price;
            }

            increaseQty(){
                this.qty++;
            }

            decreaseQty(){
                this.qty--;
            }

            getTotal(){
                return Math.round( (this.qty * this.price) * 100) / 100;
            }
        }

        class Cart {

            constructor(){
                this.items = [];
                this.list = $("#cart-list");
                this.loader = $("#loader");
                this.totalPrice = $("#totalPrice");
            }

            toggleLoader(){
                this.loader.toggleClass('active');
            }

            addItem(item){
                this.items.push(item);
            }

            getItems(){
                return this.items;
            }

            getTotal(){
                let total = 0;
                this.items.forEach(function (item) {
                    total += item.qty * item.price;
                });
                //Round to two decimal
                return Math.round(total * 100) / 100;
            }

            itemExists(id){
                let found = null;
                this.items.forEach(function (item) {
                    if(item.id === id)
                        found = item;
                });
                return found;
            }

            update(){
                this.toggleLoader();
                this.list.html("");
                let c = this;
                this.items.forEach(function (item) {
                    c.appendToList(item);
                    $("#item-qta-" + item.id).val(item.qty);
                });
                this.totalPrice.html( this.getTotal() );
                this.handleExit();
                this.toggleLoader();
            }

            handleExit(){
                if(this.items.length > 0){
                    window.onbeforeunload = function () {
                        return "Ci sono prodotti nella cassa. Vuoi davvero uscire?";
                    }
                } else {
                    window.onbeforeunload = null;
                }
            }

            appendToList(item){
                this.list.append(
                    '<tr id="item-'+item.id+'">' +
                    //'<td><i class="fe fe-x text-red"></i></td>' +
                    '<td>'+item.name+'<br /><p class="badge badge-default">Totale: '+item.qty+' x '+item.price+' = '+item.getTotal()+'</p></td>' +
                    '<td class="text-right float-right">' +
                    '<div class="input-group">' +
                    '<span class="input-group-prepend">' +
                    '<button type="button" class="btn btn-primary del" data-id="'+item.id+'">-</button>' +
                    '</span>' +
                    '<input type="text" class="form-control" style="width: 70px;" id="item-qta-'+item.id+'" value="0" disabled>' +
                    '<span class="input-group-append">' +
                    '<button type="button" class="btn btn-primary add" data-id="'+item.id+'">+</button>' +
                    '</span>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
                );
            }

            deleteFromList(item){
                this.list.find("#item-" + item.id).remove();
                this.totalPrice.html( this.getTotal() );

                let index = this.items.indexOf(item);
                if (index > -1) {
                    this.items.splice(index, 1);
                }

                this.handleExit();
            }

            add(id){
                let i = this.itemExists(id);
                if(i !== null){
                    i.increaseQty();
                    this.update();
                }
            }

            del(id){
                let i = this.itemExists(id);
                if(i !== null){
                    i.decreaseQty();
                    //Check if new quantity is 0
                    if(i.qty === 0){
                        this.deleteFromList(i);
                    } else {
                        this.update();
                    }
                }
            }

            emptyCart(){
                this.list.html("");
                this.items = [];
                this.update();
            }
        }

        $(document).ready(function () {
            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

            let cart = new Cart();

            $(".addItem").on('click', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                let name = $(this).data('name');
                let price = $(this).data('price');

                //Check if item exists in cart
                let c = cart.itemExists(id);
                if( c == null ){
                    //Create new item and add it to cart
                    c = new Item(id, name, 1, price);
                    cart.addItem(c);
                } else {
                    //Increase quantity
                    c.increaseQty();
                }

                //Trigger update
                cart.update();
            });

            $("#cart-list").on('click', '.add', function () {
                let id = $(this).data('id');
                //Get item
                cart.add(id);
            });

            $("#cart-list").on('click', '.del', function () {
                let id = $(this).data('id');
                //Get item
                cart.del(id);
            });

            $(".empty").on('click', function () {
                swal({
                    title: "Conferma operazione",
                    text: "Vuoi davvero svuotare la cassa?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: {
                        cancel: {
                            text: "Annulla",
                            closeModal: true,
                        },
                        confirm: {
                            text: "Conferma",
                            closeModal: false,
                        }
                    },
                })
                    .then((confirm) => {
                        if (confirm) {
                            cart.emptyCart();
                            swal.close();
                        } else {
                            swal.close();
                        }
                    });
            });

            $(".send").on('click', function(){
                if(cart.getItems().length === 0)
                    return false;
                swal("Vuoi confermare le transazioni?", {
                    buttons: {
                        canc: {
                            text: "Annulla",
                            value: "cancel",
                        },
                        catch: {
                            text: "Conferma!",
                            value: "confirm",
                            closeModal: false,
                        }
                    },
                })
                    .then((value) => {
                        switch (value) {
                            case "cancel":
                                swal("Transazione annullata!");
                                swal.close();
                                break;
                            case "confirm":
                                return fetch('/transactions/bar', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                    },
                                    body: JSON.stringify(cart.getItems())
                                });
                        }
                    })
                    .then(results => {
                        return results.json();
                    })
                    .then(json => {
                        if(json.success === false){
                            swal("Ops!", json.msg, "error");
                        } else {
                            cart.emptyCart();
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        swal("Ops!", "Si è verificato un errore durante l'invio della richiesta.", "error");
                        swal.stopLoading();
                        swal.close();
                    })
                ;
            });

            $('.workshiftChange').on('click', function () {
                let status = $(this).data('status');
                cart.emptyCart();
                swal("Confermare lo stato del turno in " + ((status === 'open') ? 'aperto' : 'chiuso') + '?', {
                    buttons: {
                        canc: {
                            text: "Annulla",
                            value: "cancel",
                        },
                        catch: {
                            text: "Conferma!",
                            value: "confirm",
                            closeModal: false,
                        }
                    },
                })
                    .then((value) => {
                        switch (value) {
                            case "cancel":
                                swal("Modifica annullata!");
                                swal.close();
                                break;
                            case "confirm":
                                return fetch('/workshifts/' + status, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                    }
                                });
                        }
                    })
                    .then(results => {
                        return results.json();
                    })
                    .then(json => {
                        if(json.success === false){
                            swal("Ops!", json.msg, "error");
                        } else {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        if(!error){
                            swal("Ops!", "Si è verificato un errore durante l'invio della richiesta.", "error");
                            swal.stopLoading();
                            swal.close();
                        }
                    })
            });
        });
    </script>
@endpush