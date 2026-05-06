<x-layouts.app>
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('Cashier') }}</span>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Cashier POS') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Transaction and invoice management') }}</p>
    </div>

    {{-- Row 1: Add Product & Big Total Price --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="md:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Add Product') }}
                </label>
                <select id="productSelect"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                    <option value="">{{ __('-- Select Product --') }}</option>
                    @foreach($produks as $produk)
                    <option value="{{ $loop->index }}"
                        data-id="{{ $produk->id }}"
                        data-name="{{ $produk->name }}"
                        data-price="{{ $produk->harga_jual }}"
                        data-harga_beli="{{ $produk->harga_beli }}
                        data-unit="{{ $produk->satuan }}">
                        {{ $produk->name }} - {{ $produk->satuan }} (Rp {{ number_format($produk->harga_jual, 0, ',', '.') }})
                    </option>
                    @endforeach
                </select>
                <div class="flex gap-2 mt-3">
                    <input type="number" id="productQty" value="1" min="1"
                        class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm text-center">
                    <button id="addProductBtn"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        {{ __('Add to Cart') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 h-full flex flex-col">
                <div class="">
                    <span class="text-gray-600 dark:text-gray-400 uppercase">{{ __('TOTAL AMOUNT') }}</span>
                    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mt-2 text-right" id="bigTotalPrice">
                        Rp 0
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 2: Main Content - Cart Table (col-9) & Right Panel (col-3) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-4">
        {{-- Cart Table - col-9 --}}
        <div class="lg:col-span-9">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                <div class="overflow-x-auto min-h-[400px]">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 w-16">No</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Product</th>
                                <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Price</th>
                                <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300 w-24">Qty</th>
                                <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300 w-24">Unit</th>
                                <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Sub Total</th>
                                <th class="px-4 py-3 text-center w-16">Action</th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody">
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                                    {{ __('No items added yet') }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot id="cartTableFooter" class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 font-medium">
                            <!-- Dynamic footer will be inserted here -->

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Panel - col-3 (stuff to add later) --}}
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                    {{ __('Transaction Summary') }}
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Subtotal') }}</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200" id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Discount') }}</span>
                        <span class="font-medium text-red-600 dark:text-red-400" id="discountAmount">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200 dark:border-gray-700">
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Total') }}</span>
                        <span class="text-blue-600 dark:text-blue-400" id="total">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 3: Discount Input, Payment Method, and Process Button --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
        <div class="lg:col-span-9">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Discount (%)') }}
                        </label>
                        <input type="number" id="discountPercent" value="0" min="0" max="100" step="1"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Payment Method') }}
                        </label>
                        <select id="paymentMethod"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">{{ __('-- Select Payment Method --') }}</option>
                            @foreach($tipe_pembayarans as $tipe_pembayaran)
                            <option value="{{ $tipe_pembayaran->id }}" data-name="{{ $tipe_pembayaran->name }}">
                                {{ $tipe_pembayaran->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Payment Amount') }}
                        </label>
                        <input type="number" id="paymentAmount" placeholder="Payment amount"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                    <div class="flex-1 min-w-[100px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Change') }}
                        </label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-900 rounded-md text-right font-bold text-green-600 dark:text-green-400" id="changeAmount">
                            Rp 0
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3">
            <button id="processPaymentBtn"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 text-lg h-full">
                {{ __('Process Payment') }}
            </button>
        </div>
    </div>

    {{-- INVOICE MODAL (same as before) --}}
    <div id="invoiceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('INVOICE') }}</h3>
                <button onclick="closeInvoiceModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4" id="invoiceContent">
                {{-- Dynamic invoice content will be inserted here --}}
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex gap-2">
                <button onclick="printInvoice()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded-md transition">Print</button>
                <button onclick="closeInvoiceModal()" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-medium py-2 rounded-md transition">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Cart state
        let cart = [];
        let nextId = 1;

        // DOM Elements
        const productSelect = document.getElementById('productSelect');
        const productQty = document.getElementById('productQty');
        const addProductBtn = document.getElementById('addProductBtn');
        const cartTableBody = document.getElementById('cartTableBody');
        const subtotalEl = document.getElementById('subtotal');
        const discountAmountEl = document.getElementById('discountAmount');
        const totalEl = document.getElementById('total');
        const bigTotalPrice = document.getElementById('bigTotalPrice');
        const discountPercentInput = document.getElementById('discountPercent');
        const paymentMethodSelect = document.getElementById('paymentMethod');
        const paymentAmountInput = document.getElementById('paymentAmount');
        const changeAmountEl = document.getElementById('changeAmount');

        // Helper: Format Rupiah
        function formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }

        // Calculate totals
        function calculateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discountPercent = parseFloat(discountPercentInput.value) || 0;
            const discountAmount = subtotal * (discountPercent / 100);
            const total = subtotal - discountAmount;

            subtotalEl.textContent = formatRupiah(subtotal);
            discountAmountEl.textContent = formatRupiah(discountAmount);
            totalEl.textContent = formatRupiah(total);
            bigTotalPrice.textContent = formatRupiah(total);

            return {
                subtotal,
                discountAmount,
                total,
                discountPercent
            };
        }

        // Calculate change
        function calculateChange() {
            const totalText = totalEl.textContent.replace(/[^0-9]/g, '');
            const total = parseInt(totalText) || 0;
            const payment = parseInt(paymentAmountInput.value) || 0;
            const change = payment - total;
            changeAmountEl.textContent = formatRupiah(change > 0 ? change : 0);
            return {
                total,
                payment,
                change
            };
        }

        // Update cart table
        function updateCartTable() {
            if (cart.length === 0) {
                cartTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                            {{ __('No items added yet') }}
                        </td>
                    </tr>
                `;
                calculateTotals();
                calculateChange();
                return;
            }

            let html = '';
            cart.forEach((item, index) => {
                const subTotal = item.price * item.quantity;
                html += `
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">${index + 1}</td>
                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-200">${escapeHtml(item.name)}</td>
                        <td class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">${formatRupiah(item.price)}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="adjustQuantity(${index}, -1)" 
                                    class="w-6 h-6 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">-</button>
                                <span class="w-10 text-center text-gray-800 dark:text-gray-200">${item.quantity}</span>
                                <button onclick="adjustQuantity(${index}, 1)" 
                                    class="w-6 h-6 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">+</button>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">${escapeHtml(item.unit)}</td>
                        <td class="px-4 py-3 text-right font-medium text-gray-800 dark:text-gray-200">${formatRupiah(subTotal)}</td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="removeFromCart(${index})" 
                                class="text-red-500 hover:text-red-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                `;
            });

            cartTableBody.innerHTML = html;
            calculateTotals();
            calculateChange();
        }

        // Adjust quantity
        window.adjustQuantity = function(index, delta) {
            if (cart[index]) {
                const newQty = cart[index].quantity + delta;
                if (newQty <= 0) {
                    removeFromCart(index);
                } else {
                    cart[index].quantity = newQty;
                    updateCartTable();
                }
            }
        };

        // Remove from cart
        window.removeFromCart = function(index) {
            cart.splice(index, 1);
            updateCartTable();
        };

        // Add product to cart
        function addToCart(id, name, price, harga_beli, unit) {
            const existing = cart.find(item => item.name === name && item.price === price);
            if (existing) {
                existing.quantity++;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    harga_beli: harga_beli,
                    unit: unit,
                    quantity: 1
                });
            }
            updateCartTable();
        }

        // Add product button click
        addProductBtn.addEventListener('click', () => {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (!productSelect.value) {
                alert('Please select a product.');
                return;
            }
            const id = selectedOption.dataset.id;
            const name = selectedOption.dataset.name;
            const price = parseInt(selectedOption.dataset.price);
            const harga_beli = parseInt(selectedOption.dataset.harga_beli);
            const unit = selectedOption.dataset.unit;
            let qty = parseInt(productQty.value);

            if (isNaN(qty) || qty < 1) {
                qty = 1;
            }

            for (let i = 0; i < qty; i++) {
                addToCart(name, price, unit);
            }

            productSelect.value = '';
            productQty.value = '1';
        });

        // Enter key on product qty
        productQty.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                addProductBtn.click();
            }
        });

        // Discount input event
        discountPercentInput.addEventListener('input', function() {
            let value = parseInt(this.value) || 0;
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
            updateCartTable();
        });

        // Payment amount input event
        paymentAmountInput.addEventListener('input', calculateChange);

        // Process payment
        document.getElementById('processPaymentBtn').addEventListener('click', () => {
            if (cart.length === 0) {
                alert('Cart is empty. Add some products first.');
                return;
            }

            const paymentMethodId = paymentMethodSelect.value;
            const paymentMethodName = paymentMethodSelect.options[paymentMethodSelect.selectedIndex]?.dataset.name || '';

            if (!paymentMethodId) {
                alert('Please select a payment method.');
                paymentMethodSelect.focus();
                return;
            }

            const {
                total,
                payment,
                change
            } = calculateChange();
            if (payment < total) {
                alert('Insufficient payment. Please enter amount greater than or equal to total.');
                return;
            }

            const subtotalText = subtotalEl.textContent.replace(/[^0-9]/g, '');
            const subtotal = parseInt(subtotalText) || 0;
            const discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
            const discountAmount = subtotal * (discountPercent / 100);
            const totalAfterDiscount = subtotal - discountAmount;
            const paymentMethodSelect = document.getElementById('paymentMethod');

            // Create a form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("kasir.processpayment") }}';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // Add form data
            const formData = {
                subtotal_before_discount: subtotal,
                subtotal_after_discount: totalAfterDiscount,
                discount_percent: discountPercent,
                discount_amount: discountAmount,
                total_payment: totalAfterDiscount,
                payment_method_id: paymentMethodId,
                payment_amount: payment,
                change_amount: change,
                cart_items: JSON.stringify(cart.map(item => ({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    harga_beli: item.harga_beli,
                    quantity: item.quantity,
                    unit: item.unit,
                    total: item.price * item.quantity
                })))
            };

            for (const [key, value] of Object.entries(formData)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();


        });

        // Show invoice modal
        function showInvoice(data) {
            let itemsHtml = '';
            data.items.forEach((item, idx) => {
                const itemTotal = item.price * item.quantity;
                itemsHtml += `
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="py-2 text-sm">${idx + 1}</td>
                        <td class="py-2 text-sm">${escapeHtml(item.name)}</td>
                        <td class="py-2 text-sm text-center">${item.quantity}</td>
                        <td class="py-2 text-sm text-right">${formatRupiah(item.price)}</td>
                        <td class="py-2 text-sm text-right">${formatRupiah(itemTotal)}</td>
                    </tr>
                `;
            });

            const invoiceHtml = `
                <div class="text-center border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-xl font-bold">STORE NAME</h2>
                    <p class="text-xs text-gray-500">Jl. Example No. 123, City</p>
                    <p class="text-xs text-gray-500">Tel: (021) 1234567</p>
                </div>
                <div class="flex justify-between text-xs text-gray-500 pt-2">
                    <span>Invoice: ${data.transaction_id}</span>
                    <span>${data.date}</span>
                </div>
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Cashier: ${data.cashier}</span>
                    <span>Payment: ${data.payment_method_name}</span>
                </div>
                <table class="w-full text-sm mt-4">
                    <thead class="border-b border-gray-300 dark:border-gray-600">
                        <tr>
                            <th class="text-left py-1">#</th>
                            <th class="text-left py-1">Item</th>
                            <th class="text-center py-1">Qty</th>
                            <th class="text-right py-1">Price</th>
                            <th class="text-right py-1">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${itemsHtml}
                    </tbody>
                </table>
                <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-3 space-y-1 text-sm">
                    <div class="flex justify-between"><span>Subtotal</span><span>${formatRupiah(data.subtotal)}</span></div>
                    <div class="flex justify-between"><span>Discount (${data.discountPercent}%)</span><span>- ${formatRupiah(data.discountAmount)}</span></div>
                    <div class="flex justify-between font-bold text-base pt-1"><span>TOTAL</span><span>${formatRupiah(data.total)}</span></div>
                    <div class="flex justify-between"><span>Payment (${data.payment_method_name})</span><span>${formatRupiah(data.payment)}</span></div>
                    <div class="flex justify-between text-green-600"><span>Change</span><span>${formatRupiah(data.change)}</span></div>
                </div>
                <div class="text-center text-xs text-gray-400 mt-6 pt-3 border-t border-gray-200 dark:border-gray-700">
                    Thank you for shopping with us!
                </div>
            `;

            document.getElementById('invoiceContent').innerHTML = invoiceHtml;
            document.getElementById('invoiceModal').classList.remove('hidden');
            document.getElementById('invoiceModal').classList.add('flex');
        }

        window.closeInvoiceModal = function() {
            document.getElementById('invoiceModal').classList.add('hidden');
            document.getElementById('invoiceModal').classList.remove('flex');
        };

        window.printInvoice = function() {
            const printContent = document.getElementById('invoiceContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head><title>Print Invoice</title>
                <style>
                    body { font-family: monospace; padding: 20px; max-width: 400px; margin: 0 auto; }
                    .text-center { text-align: center; }
                    .text-right { text-align: right; }
                    table { width: 100%; border-collapse: collapse; }
                    td, th { padding: 8px 4px; }
                </style>
                </head>
                <body>${printContent}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        };

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Initialize
        updateCartTable();
    </script>
</x-layouts.app>