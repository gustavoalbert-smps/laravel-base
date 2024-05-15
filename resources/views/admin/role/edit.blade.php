<x-app-layout>
    @section('styles')
        <style>
            #permissions-list,
            #permissions-list * {
                list-style-type: none;
                margin: 0;
                padding: 0 0 5px 0;
            }

            #permissions-list img.arrow {
                padding: 2px 0 0 0;
                border: 0;
                width: 20px;
            }

            #permissions-list li {
                padding: 4px 0 0 0;
            }

            #permissions-list li ul {
                padding: 0 0 0 20px;
                margin: 0;
            }

            #permissions-list label {
                cursor: pointer;
                font-weight: bold;
                padding: 2px 0;
            }

            #permissions-list label.hover {
                color: red;
            }

            #permissions-list li .arrow {
                width: 20px;
                height: 18px;
                padding: 0;
                margin: 0;
                cursor: pointer;
                float: left;
                background: transparent no-repeat 0 0px;
            }

            #permissions-list li .collapsed {
                background-image: url('{{ url('assets/images/right.svg') }}');
            }

            #permissions-list li .expanded {
                background-image: url('{{ url('assets/images/down.svg') }}');
            }

            #permissions-list li .checkbox {
                width: 20px;
                height: 18px;
                padding: 0;
                margin: 0;
                cursor: pointer;
                float: left;
                background: url('{{ url('assets/images/square.svg') }}') no-repeat 0 0px;
            }

            #permissions-list li .checked {
                background-image: url('{{ url('assets/images/check.svg') }}');
            }

            #permissions-list li .half_checked {
                background-image: url('{{ url('assets/images/square-minus.svg') }}');
            }
        </style>
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Role
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section>
                        <header class="mb-4">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Roles') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Configure system role permissions.') }}
                            </p>
                        </header>

                        <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div id="tree">
                            </div>
                            <div class="row">
                                <div class="col">

                                    <button class="btn btn-success float-end" role="button" type="submit">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            var data = @json($data);
            var rolePermissions = @json($rolePermissions);
            var allPermissions = @json($allPermissions);

            function convertToTree(data) {
                let tree = [];
                for (let key in data) {
                    let item = data[key];
                    let node = {
                        label: item.label,
                        name: item.name,
                        value: item.value,
                        childs: [],
                        subgroups: []
                    };
                    if (item.childs) {
                        node.childs = convertToTree(item.childs);
                    }
                    if (item.subgroups) {
                        node.subgroups = convertToTree(item.subgroups);
                    }
                    tree.push(node);
                }
                return tree;
            }

            function checkPermission(permissions) {
                for (let i = allPermissions[0]; i <= allPermissions.length; i++) {
                    if (permissions.includes(i)) {
                        let parent = $(`input[type="checkbox"][value="${i}"]`).parent();

                        $(parent.find('.checktree.checkbox')).trigger('click');
                    }
                }
            }

            function generateMenu(data) {
                let menuHtml = `<li>
                            <input type="checkbox">
                            <label>${data.label}</label>`,
                    havePermission = [];
                    menuHtml += `<ul>`;

                    if (data.hasOwnProperty('subgroups') && data.subgroups.length > 0) {
                        data.subgroups.forEach(subgroup => {
                            let object = generateMenu(subgroup);
                            menuHtml += object.html;
                            havePermission = Array.from(new Set([...havePermission, ...object.array]));
                        });
                    }

                    if (data.childs.length > 0) {
                        data.childs.forEach(child => {
                            menuHtml += `<li>
                                    <input type="checkbox" value="${child.value}" name="${child.name}">
                                    <label>${child.label}</label>
                                </li>`;

                            if (rolePermissions.includes(child.value))
                                havePermission.push(child.value);
                        });
                    }

                    menuHtml += '</ul>';
                    menuHtml += `</li>`;

                return { html: menuHtml, array: havePermission };
            }

            function generateTreeHtml(data) {
                let treeHtml = '<ul id="permissions-list">',
                    havePermission = [];

                data.forEach(item => {
                    let object = generateMenu(item);
                    treeHtml += object.html;
                    havePermission = Array.from(new Set([...havePermission, ...object.array]));                    
                });

                treeHtml += '</ul>';

                $('#tree').append(treeHtml);
                $('#permissions-list').checkTree();
                checkPermission(havePermission);
            }

            $(document).ready(function() {
                var treeData = convertToTree(data);
                generateTreeHtml(treeData);
            });
        </script>
    @endsection
</x-app-layout>
