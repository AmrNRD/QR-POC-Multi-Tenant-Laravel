<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                name: '{{ getData($data, 'name') }}',
                email: '{{ getData($data, 'email') }}',
                address: '{{ getData($data, 'address') }}',
                admin:{
                    name: '{{ getData($data, 'name') }}',
                    email: '{{ getData($data, 'email') }}',
                    password: '{{ getData($data, 'password') }}',
                    password_confirmation: '{{ getData($data, 'password_confirmation') }}',
                },

                /**/
                @if ($action == 'edit')
                _method: 'PATCH',
                @endif
            },
            isLoading: false,
            validation_errors: [],
        },
        mounted () {

        },
        methods: {
            submit (option = 'create') {

                let request = {

                    method: '{{$action == "edit" ? "put" : "post"}}',

                    url:'{{ $submitUrl }}',

                    data:this.fData,

                    toaster:{
                        success:{
                            title:"Admin Saved",
                            subtitle:"Admin",
                            body:"Admin has been "+ '{{$action == "edit" ? "Edited" : "Created"}}'+" successfully in the system"
                        },
                        fail:{
                            title:"Failed",
                            subtitle:"Fail",
                            body:"Admin has not been "+ '{{$action == "edit" ? "Edited" : "Created"}}'+" successfully in the system"
                        }
                    }
                }
                @if(isset($redirectTo))
                    request.redirect = '{{ $redirectTo }}'
                @else
                if(option == 'continue'){
                    request.redirect = '{{ route("companies.create") }}'
                }else{
                    request.redirect = '{{ route("companies.index") }}'
                }
                @endif

                    this.isLoading = true;

                this.submitForm(
                    request,
                    (res)=>{
                        this.isLoading = false;
                    },(err)=>{
                        this.isLoading = false;
                    });

            },
            onChangeRole(event) {
                console.log(event.target.id)
            }
        },
    });
</script>
