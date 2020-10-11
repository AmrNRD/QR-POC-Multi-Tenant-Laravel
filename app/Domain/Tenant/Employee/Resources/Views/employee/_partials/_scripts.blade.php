<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                user_id: '{{ getData($data, 'user_id') }}',
                gender: '{{ getData($data, 'gender') }}',
                address: '{{ getData($data, 'address') }}',
                date_of_birth: '{{ getData($data, 'date_of_birth') }}',
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

                    method: "post",

                    url:'{{ $submitUrl }}',

                    data:this.fData,

                    toaster:{
                        success:{
                            title:"Employee Saved",
                            subtitle:"Employee",
                            body:"Employee has been inserted successfully in the system"
                        },
                        fail:{
                            title:"Failed",
                            subtitle:"Fail",
                            body:"Employee has not been inserted successfully in the system"
                        }
                    }
                }
                if(option == 'continue'){
                    request.redirect = '{{ route("employees.create") }}'
                }else{
                    request.redirect = '{{ route("employees.index") }}'
                }

                this.isLoading = true

                this.submitForm(
                    request,
                    (res)=>{
                        this.isLoading = false
                    },(err)=>{
                        this.isLoading = false
                    });

            },
        },
    });
</script>
