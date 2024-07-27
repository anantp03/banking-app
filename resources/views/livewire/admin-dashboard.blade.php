<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-12xl sm:px-6 lg:px-8">
            <div class="row">
                <div class="max-w-5x">
                    <x-secondary-button class="my-4 float-right add-more-account">
                        {{ __('Add More Account') }}
                    </x-secondary-button>
                </div>
                <form method="POST" action="{{ route('create.account') }}" id="register-account">
                    @csrf
                    <div class="col-md-12">
                        <div class="row" id="new_forms"></div>
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
        $("#account-submit").hide();

        function addAccount(answerCount) {
            var accountForm = `<div class="col-lg-4 col-mg-4 account py-4" id="account_${answerCount}">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                                    <div class="p-6 text-gray-900">
                                        <div>
                                            <x-secondary-button class="float-right remove-account">Remove</x-secondary-button>
                                        </div>
                                        <!-- First Name -->
                                        <div class="mt-4">
                                            <x-input-label for="firstname_${answerCount}" :value="__('First Name')" />
                                            <x-text-input id="firstname_${answerCount}" class="block mt-1 w-full" type="text" name="firstname[]" :value="old('firstname_${answerCount}')" required autofocus autocomplete="firstname_${answerCount}" />
                                            <x-input-error :messages="$errors->get('firstname_${answerCount}')" class="mt-2" />
                                        </div>

                                        <!-- Last Name -->
                                        <div class="mt-4">
                                            <x-input-label for="lastname_${answerCount}" :value="__('Last Name')" />
                                            <x-text-input id="lastname_${answerCount}" class="block mt-1 w-full" type="text" name="lastname[]" :value="old('lastname_${answerCount}')" required autofocus autocomplete="lastname_${answerCount}" />
                                            <x-input-error :messages="$errors->get('lastname_${answerCount}')" class="mt-2" />
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="mt-4">
                                            <x-input-label for="dob_${answerCount}" :value="__('Date Of Birth')" />
                                            <x-flatpickr id="dob_${answerCount}" class="block mt-1 w-full" type="text" name="dob[]" :value="old('dob_${answerCount}')" required autocomplete="dob_${answerCount}" />
                                            <x-input-error :messages="$errors->get('dob_${answerCount}')" class="mt-2" />
                                        </div>

                                        <div class="mt-4">
                                            <x-input-label for="address_${answerCount}" :value="__('Address')" />
                                            <textarea  class="form-control" id="address_${answerCount}" class="block mt-1 w-full" name="address[]" >{{old('address')}}</textarea>
                                            <x-input-error :messages="$errors->get('address_${answerCount}')" class="mt-2" />
                                        </div>

                                    </div>
                                </div>
                            </div>`;

            $("#new_forms").append(accountForm);
            // Re-validate the form
            $("#register-account").validate().settings.ignore = ":hidden";
        }

        var count = 0;
        $(".add-more-account").click(function () {
            count++;
            if(count > 0){
                $("#account-submit").show();
            }
            addAccount(count);
        });
        $('body').on('click', '.remove-account',function () {
            $(this).parent().parent().remove();
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

