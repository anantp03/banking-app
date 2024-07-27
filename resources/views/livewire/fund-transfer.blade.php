<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-12xl sm:px-6 lg:px-8">
            <div class="row margin-auto">
                <form method="POST" action="{{ route('create.account') }}" id="register-account">
                    @csrf
                    <div class="col-md-12">
                        <div class="col-lg-4 col-mg-4 account py-4" id="account_${answerCount}">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                                <div class="p-6 text-gray-900">
                                    <!-- From Account Number -->
                                    <div class="mt-4">
                                        <x-input-label for="from_account" :value="__('From Account Number')" />
                                        <x-text-input id="from_account" class="block mt-1 w-full" type="text" name="from_account" :value="old('from_account')" readonly="" autofocus autocomplete="from_account" />
                                    </div>

                                    <!-- To Account Number -->
                                    <div class="mt-4">
                                        <x-input-label for="to_account" :value="__('To Account Number')" />
                                        <x-text-input id="to_account" class="block mt-1 w-full" type="text" name="to_account" :value="old('to_account')" required autofocus autocomplete="to_account" />
                                        <x-input-error :messages="$errors->get('to_account')" class="mt-2" />
                                    </div>

                                    <!-- Amount to Transfer -->
                                    <div class="mt-4">
                                        <x-input-label for="amount" :value="__('Amount To Transfer')" />
                                        <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" required autofocus autocomplete="amount" />
                                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                    </div>

                                    <!-- To Currency -->
                                    <div class="mt-4">
                                        <x-input-label for="currency" :value="__('Currency')" />
                                        <x-select-dropdown id="currency" class="block mt-1 w-full" type="number" name="currency" :value="old('currency')" required autofocus autocomplete="currency" />
                                        <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                                    </div>

                                    <!-- Amount to Transfer -->
                                    <div class="mt-4">
                                        <x-input-label for="receive_amount" :value="__('Amount To Receive')" />
                                        <x-text-input id="receive_amount" class="block mt-1 w-full" type="number" name="receive_amount" :value="old('receive_amount')" required autofocus autocomplete="receive_amount" />
                                        <x-input-error :messages="$errors->get('receive_amount')" class="mt-2" />
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4" id="account-submit">
                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function () {
        // set endpoint and your access key
        endpoint = 'latest'
        access_key = '{{config('services.exchangerates.key')}}';

        from_currency = 'USD';
        to_currency = 'GBP';

        $("#amount").on("keyup", function(e) {
            amount = $(this).val();

            // get the most recent exchange rates via the "latest" endpoint:
            $.ajax({
                url: 'http://api.exchangeratesapi.io/v1/'+ endpoint +'?access_key='+access_key,
                dataType: 'json',
                success: function(json) {

                    // exchange rata data is stored in json.rates
                    alert(json.rates.GBP);

                    // base currency is stored in json.base
                    alert(json.base);

                    // timestamp can be accessed in json.timestamp
                    alert(json.timestamp);

                }
            });
        });



        //Account form validation
        $('#register-account').validate({
            errorPlacement: function (error, element) {
                if (element.attr("name") == "dob[]") {
                    $(element).parent().parent().append(error);
                } else {
                    $(element).parent().append(error);
                }
            },
            rules: {
                'firstname[]': {
                    required: true,
                    allrequired: true,
                },
                'lastname[]': {
                    required: true,
                    allrequired: true,
                },
                'dob[]': {
                    required: true,
                    allrequired: true,
                },
                'address[]': {
                    required: true,
                    minlength:8,
                    allrequired: true,
                },
            },
            messages:
                {
                    'firstname[]':
                        {
                            required: "First Name is a mandatory field.",
                            allrequired: "First Name is a mandatory field.",
                        },
                    'lastname[]':
                        {
                            required: "Last Name is a mandatory field.",
                            allrequired: "Last Name is a mandatory field.",
                        },
                    'dob[]':
                        {
                            required: "Date of Birth is a mandatory field.",
                            allrequired: "Date of Birth is a mandatory field.",
                        },
                    'address[]':
                        {
                            required: "Address is a mandatory field.",
                            allrequired: "Address is a mandatory field.",
                            minlength: "First name must be at least 8 characters long"
                        },
                },
        });

    });
    // Handle dynamically added elements (if any)
    $(document).on('keyup change', 'input, textarea', function() {
        var validator = $("#register-account").validate();
        validator.element(this);  // Validate the current element
    });
    $.validator.addMethod("allrequired", function(value, element, re) {
        var name = element.name;
        var type = element.type;
        var ele_type=$(element)[0].tagName.toLowerCase();
        var splitName= name.replace(/[^a-zA-Z ]/g, " ").replace(/(?:^\w|[A-Z]|\b\w)/g, function(word, index) {
            return word.toUpperCase();
        });
        var message=splitName+" is a mandatory field.";
        $(''+ele_type+'[name="'+name+'"]').each(function(i,obj){
            if(type!="file")
            {
                if(typeof $(obj).val() !='undefined' && $(obj).val()!=""){
                    displayMesage($(obj),"");
                    $(obj).removeClass('error');
                }else{
                    displayMesage($(obj),message);
                }
            }
            else
            {
                if(typeof $(obj).attr('data-value') !='undefined' && $(obj).attr('data-value')!=""){
                    displayMesage($(obj),"");
                    $(obj).removeClass('error');
                }else{
                    displayMesage($(obj),message);
                }
            }
        });
        return $(''+ele_type+'[name="'+name+'"]').map(function(i,obj)
        {
            if(obj.type == 'file')
            {
                return $(obj).attr('data-value');
            }else if(obj.type=="text"){
                return $(obj).val();
            }else{
                return $(obj).val();
            }

        }).get().every(function(v)
        {
            if(v!= "")
            {
                return true;
            }
            else
                return false;
        });
    });
    function displayMesage(obj,msg)
    {
        var input = obj, nextElement = input.next();
        var elem = ($(nextElement).is("span")) ? 1: 0;
        var eleId= $(input).attr("id");
        $(nextElement).remove();
        if(msg!="")
        {
            if(!eleId.includes('dob')){
                input.addClass('error');
                $(input).attr("area-describedy",eleId+'-error');
                $(input).after('<label id="'+eleId+'-error" class="error">'+msg+'</label>');
            }else{
                $(input).closest().find('.error').remove();
                input.addClass('error');
                $(input).attr("area-describedy",eleId+'-error');
                $(input).parent().last().after('<label id="'+eleId+'-error" class="error">'+msg+'</label>');
            }
            // if(elem==0)
            // {

            // }
            // else{
            // $(nextElement).html(msg);
            // $(input).after('<span id="'+eleId+'-error" class="error">'+msg+'</span>');
            // }
        }
        else
        {
            // if(elem==1)
            // {
            //     input.removeClass('error');
            //     nextElement.remove();
            // }
        }
    }
</script>

