<script>

    var vue = new Vue({
        el: '#table',
        data: {
            fData: {
            },
            isLoading: false,
            validation_errors: [],
        },
        mounted () {

        },
        methods: {

            onChange(id,event) {
                console.log(id);
                console.log(event.value);

                let request = {

                    method: "post",

                    url:'{{ url("/activate-device") }}'+"/"+id,

                    data:{'active':event.value===true?"active":"inactive"},

                    toaster:{
                        success:{
                            title:"Device "+(event.value===true?"Activated":"Deactivated"),
                            subtitle:"Device",
                            body:"Device has been "+(event.value===true?"Activated":"Deactivated")+" successfully in the system"
                        },
                        fail:{
                            title:"Failed",
                            subtitle:"Fail",
                            body:"Device has been Activated successfully in the system"
                        }
                    }
                }
                request.redirect =null;


                this.isLoading = true;
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
