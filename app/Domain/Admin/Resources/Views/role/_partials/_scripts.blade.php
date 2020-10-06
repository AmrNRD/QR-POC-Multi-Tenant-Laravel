<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                name: '{{ getData($data, 'name') }}',
                slug: '{{ getData($data, 'slug') }}',
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
                            title:"Role Saved",
                            subtitle:"Role",
                            body:"Role has been inserted successfully in the system"
                        },
                        fail:{
                            title:"Process Failer",
                            subtitle:"Failed",
                            body:"Failed inserting role"
                        }
                    }
                }
                if(option == 'continue'){
                    request.redirect = '{{ route("roles.create") }}'
                }else{
                    request.redirect = '{{ route("roles.index") }}'
                }

                this.isLoading = true;

                this.submitForm(
                    request,
                    (res)=>{
                        this.isLoading = false;
                    },(err)=>{
                        this.isLoading = false;
                    });

            },
        },
    });
</script>
