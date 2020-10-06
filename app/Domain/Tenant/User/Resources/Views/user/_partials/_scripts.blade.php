<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                name: '{{ getData($data, 'name') }}',
                email: '{{ getData($data, 'email') }}',
                password: '{{ getData($data, 'password') }}',
                password_confirmation: '{{ getData($data, 'password_confirmation') }}',
                role_id:'{{getData($data,'role_id')}}',
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
                            title:"User Saved",
                            subtitle:"User",
                            body:"User has been "+ '{{$action == "edit" ? "Edited" : "Created"}}'+" successfully in the system"
                        },
                        fail:{
                            title:"Failed",
                            subtitle:"Fail",
                            body:"User has not been "+ '{{$action == "edit" ? "Edited" : "Created"}}'+" successfully in the system"
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
                        console.log("heeeeere");
                        this.isLoading = false;
                    });

            },
            onChangeRole(event) {
                console.log(event.target.id)
            }
        },
    });
</script>
