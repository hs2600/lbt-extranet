<div>

    <!-- { print_r(session()->all()) } -->
    <!-- { session()->get('cust') } -->


    <?php

    // only show if price is available
    if (is_null($price) == false || $price == 0) {

    ?>
        <div class="row">
            <div class="col-lg-6">

                <b>${{ number_format(sprintf("%.2f", $product->price), 2) }} </b>
                <i> per {{ strtolower($product->uofm) }} </i>

            </div>
            <?php

            //Only show customer list (drop-down) if user role is not CUSTOMER and user has LBT email address
            if (Auth::user()->role != 'customer' && Auth::user()->role != '' && strpos(Auth::user()->email, "lunadabaytile.com") == true) {

            ?>
                <div class="col">
                    <select id="customers" class="form-control" wire:model="customer">
                        <?php
                        if (session()->get('cust') != "") {
                            echo '<option value="'.session()->get('cust').'">'.session()->get('custname').'</option>';
                        } else {
                            echo '<option value="">--Customer--</option>';
                        }
                        //Add customer list to drop-down
                        ?>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->customer }}">
                            {{ $customer->custname }}
                        </option>
                        @endforeach
                    </select>
                </div>
            <?php
            }
            ?>

        </div>
    <?php
    }

    ?>


</div>