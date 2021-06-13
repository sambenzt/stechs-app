<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stechs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        body{ background-color: #ececec; }
        tbody td { padding: 15px 0px!important; }
        .c-pointer{ cursor: pointer; }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-primary">
        <div class="container-fluid">
        <span class="navbar-brand mb-0 h1 text-white">Stechs</span>
        </div>
    </nav>
    
    <main class="container p-5">
        <div class="row d-flex justify-content-center mb-4">
            <div class="col-xs-12 col-md-10">
                <input id="search" type="text" class="form-control" placeholder="Buscar fabricante">
            </div>
        </div>
        <div id="danger" style="display:none">
            <div class="row d-flex justify-content-center">
                <div class="col-xs-12 col-md-10">
                    <div class="alert alert-danger" role="alert">
                        
                    </div>
                </div>
            </div>
        </div>
        <div id="success" style="display:none">
            <div class="row d-flex justify-content-center">
                <div class="col-xs-12 col-md-10">
                    <div class="alert alert-success" role="alert">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-xs-12 col-md-10">
                <div class="card">
                    <div class="card-body p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="p-0">MAC Address</th>
                                    <th class="p-0">IP Address</th>
                                    <th class="p-0">Vendor</th>
                                    <th class="p-0">Model</th>
                                    <th class="p-0">Version</th>
                                    <th class="p-0">Add</th>
                                </tr>
                            </thead>
                            <tbody id="table-rows">
                                <tr>
                                    <td colspan="6" class="text-center">Sin datos.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>

        let state = {
            modems: [],
            error: {
                show: false,
                message: null
            },
            success: {
                show: false,
                message: null
            }
        };

        $('#search').on('keyup', function(e){

            reset();

            const str_search = $(this).val();

            const enter = str_search.length > 0 && (e.key === 'Enter' || e.keyCode === 13);

            if (enter) {
                search(str_search)
                    .then(response => state.modems = response.data)
                    .then(() => render())
                    .catch(error => handleError(error));
            }
        });

        $('tbody').on('click', '.add', function() {

            const modem_macaddr = $(this).attr('data-mac');

            const vsi_model = $(this).attr('data-model');

            add(modem_macaddr)
                .then(response => {
                    state.success.show = true;
                    state.success.message = response.message;
                })
                .then(() => filter(vsi_model))
                .then(() => render())
                .then(() => reset());
        })

        function reset() {

            state = {
                modems: [],
                error: {
                    show: false,
                    message: null
                },
                success: {
                    show: false,
                    message: null
                }
            };
        }

        function search(vendor) {

            return $.ajax({
                url: '/api/modems?vendor=' + vendor,
                type: 'GET'
            });
        }

        function add(modem_macaddr) {

            return $.ajax({
                url: '/api/modems/' + modem_macaddr,
                type: 'POST'
            });
        }

        function filter(vsi_model) {

            state.modems = state.modems.filter(modem => modem.vsi_model !== vsi_model);

        }

        function handleError(error) {

            if(error.status === 404) {

                state.error.show = true; 

                state.error.message = error.responseJSON.message;

                render();
            }
        }

        function render() {

            alert('danger', state.error.show, state.error.message);

            alert('success', state.success.show, state.success.message);

            table();            
        }

        function alert(type, display, message) {

            const div =  $('#' + type);

            div.find('.alert-' + type).text(message);

            if(display) div.fadeIn().delay(3500).fadeOut();
        }

        function table() {

            const tbody = $('tbody').empty();

            let rows;

            if(state.modems.length > 0) {

                rows = state.modems.map(modem => {
                    return `
                        <tr>
                            <td>${ modem.modem_macaddr }</td>
                            <td>${ modem.ipaddr }</td>
                            <td>${ modem.vsi_vendor }</td>
                            <td>${ modem.vsi_model }</td>
                            <td>${ modem.vsi_swver }</td>
                            <td class="c-pointer">
                                <svg class="add ml-1" data-mac="${modem.modem_macaddr}" data-model="${modem.vsi_model}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill:rgba(0, 0, 0, 1);transform:;-ms-filter:"><path d="M13 7L11 7 11 11 7 11 7 13 11 13 11 17 13 17 13 13 17 13 17 11 13 11z"></path><path d="M12,2C6.486,2,2,6.486,2,12s4.486,10,10,10c5.514,0,10-4.486,10-10S17.514,2,12,2z M12,20c-4.411,0-8-3.589-8-8 s3.589-8,8-8s8,3.589,8,8S16.411,20,12,20z"></path></svg>
                            </td>
                        </tr>
                    `;
                }).join('');

            }
            else {
                rows = `
                    <tr>
                        <td colspan="6" class="text-center">Sin datos.</td>
                    </tr>
                `;
            }

            tbody.append(rows);
        }

    </script>
</body>
</html>