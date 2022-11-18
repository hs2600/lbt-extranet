<div>

    <!-- { print_r(session()->all()) } -->
    <!-- { session()->get('cust') } -->


    <?php

    // only show if price is available
    if (is_null($price) == false) {

    ?>
        <div class="row">
            <div class="col-lg-6">

                <b>${{ number_format(sprintf("%.2f", $product->price), 2) }} </b>
                <i> per {{ strtolower($product->uofm) }} </i>

            </div>
            <?php
            if (Auth::user()->role != 'customer' && Auth::user()->role != '') {

            ?>
                <div class="col">
                    <select id="customers" class="form-control" wire:model="customer">
                        <?php
                        if (session()->get('cust') != "") {
                            echo '<option value="'.session()->get('cust').'">'.session()->get('custname').'</option>';
                        } else {
                            echo '<option value="">--Customer--</option>';
                        }

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