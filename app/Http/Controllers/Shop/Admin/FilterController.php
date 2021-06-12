<?php

    namespace App\Http\Controllers\Shop\Admin;

    use App\Http\Requests\AdminAttrsFilterAddRequest;
    use App\Http\Requests\AdminGroupFilterAddRequest;
    use App\Models\Admin\AttributeGroup;
    use App\Models\Admin\AttributeValue;
    use App\Repositories\Admin\FilterAttrsRepository;
    use App\Repositories\Admin\FilterGroupRepository;
    use MetaTag;

    class FilterController extends AdminBaseController
    {

        private $filterGroupRepository;
        private $filterAttrsRepository;


        public function __construct()
        {
            parent::__construct();
            $this->filterAttrsRepository = app(FilterAttrsRepository::class);
            $this->filterGroupRepository = app(FilterGroupRepository::class);
        }


        /** Show All Groups of Filter
         *  table->attribute_group
         */
        public function attributeGroup()
        {
            $attrs_group = $this->filterGroupRepository->getAllGroupsFilter();

            MetaTag::setTags(['title' => 'Группы фильтров']);
            return view('shop.admin.filter.attribute-group', compact('attrs_group'));
        }


        /** Delete Group of Filter
         *  table->attribute_group
         */
        public function groupDelete($id)
        {
            if (empty($id)) {
                return back()->withErrors(['msg' => "Запись [{$id}] не найдена!"]);
            }
            $count = $this->filterAttrsRepository->getCountFilterAttrsById($id);
            if ($count) {
                return back()->withErrors(['msg' => "Удаление не возможно в группе есть атрибуты"]);
            }
            $delete = $this->filterGroupRepository->deleteGroupFilter($id);
            if ($delete) {
                return back()->with(['success' => "Удалено"]);
            } else {
                return back()->withErrors(['msg' => "Ошибка удаления"]);
            }

        }


        /** Add Group for Filter
         *  table->attribute_group
         * @param AdminGroupFilterAddRequest $request
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
         */
        public function groupAdd(AdminGroupFilterAddRequest $request)
        {
            if ($request->isMethod('post')) {
                $data = $request->input();
                $group = (new AttributeGroup())->create($data);
                $group->save();

                if ($group) {
                    return redirect('/admin/filter/group-add-group')
                        ->with(['success' => 'Добавлена новая группа']);
                } else {
                    return back()
                        ->withErrors(['msg' => "Ошибка создания новой группы"])
                        ->withInput();
                }

            } else {
                if ($request->isMethod('get')) {
                    MetaTag::setTags(['title' => 'Новая группа фильтров']);
                    return view('shop.admin.filter.group-add-group');
                }
            }

        }


        /** Show All Attribute for Filters
         *  table->attribute_values
         */
        public function attributeFilter()
        {
            $attrs = $this->filterAttrsRepository->getAllAttrsFilter();
            $count = $this->filterGroupRepository->getCountGroupFilter();

            MetaTag::setTags(['title' => 'Фильтры']);
            return view('shop.admin.filter.attribute', compact('attrs', 'count'));
        }


        /** Add attribute for filter
         * @param AdminAttrsFilterAddRequest $request
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
         */
        public function attributeAdd(AdminAttrsFilterAddRequest $request)
        {
            if ($request->isMethod('post')) {

                $uniqueName = $this->filterAttrsRepository->checkUnique($request->value);

                if ($uniqueName) {
                    return redirect('/admin/filter/attrs-add')
                        ->withErrors(['msg' => 'Такой название фильтра уже есть.'])
                        ->withInput();
                }

                $data = $request->input();
                $atrr = (new AttributeValue())->create($data);
                $atrr->save();
                if ($atrr) {
                    return redirect('/admin/filter/attrs-add')
                        ->with(['success' => 'Добавлен новый фильтр']);
                } else {
                    return back()
                        ->withErrors(['msg' => "Ошибка создания фильтра"])
                        ->withInput();
                }

            } else {
                if ($request->isMethod('get')) {
                    $group = $this->filterGroupRepository->getAllGroupsFilter();
                    MetaTag::setTags(['title' => 'Новый атрибут для фильтра']);
                    return view('shop.admin.filter.attrs-add', compact('group'));
                }
            }
        }


        /** Delete Attribute filter by Id */
        public function attrDelete($id)
        {
            if (empty($id)) {
                return back()->withErrors(['msg' => "Запись [{$id}] не найдена!"]);
            }

            $delete = $this->filterAttrsRepository->deleteAttrFilter($id);

            if ($delete) {
                return back()->with(['success' => "Удалено"]);
            } else {
                return back()->withErrors(['msg' => "Ошибка удаления"]);
            }
        }


        /** Edit Group Filter
         * @param AdminGroupFilterAddRequest $request
         * @param $id
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
         */
        public function groupEdit(AdminGroupFilterAddRequest $request, $id)
        {
            if (empty($id)) {
                return back()->withErrors(['msg' => "Запись [{$id}] не найдена!"]);
            }
            if ($request->isMethod('post')) {
                $group = AttributeGroup::find($id);
                $group->title = $request->title;
                $group->save();

                if ($group) {
                    return redirect('/admin/filter/group-filter')
                        ->with(['success' => 'Успешно изменено']);
                } else {
                    return back()
                        ->withErrors(['msg' => "Ошибка изменения"])
                        ->withInput();
                }
            } else {
                if ($request->isMethod('get')) {
                    $group = $this->filterGroupRepository->getInfoProduct($id);
                    MetaTag::setTags(['title' => 'Редактирование группы']);
                    return view('shop.admin.filter.group-edit', compact('group'));
                }
            }
        }


        /** Edit Attribute Filter
         * @param AdminAttrsFilterAddRequest $request
         * @param $id
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         */
        public function attrEdit(AdminAttrsFilterAddRequest $request, $id)
        {
            if (empty($id)) {
                return back()->withErrors(['msg' => "Запись [{$id}] не найдена!"]);
            }
            if ($request->isMethod('post')) {

                $attr = AttributeValue::find($id);
                $attr->value = $request->value;
                $attr->attr_group_id = $request->attr_group_id;
                $attr->save();

                if ($attr) {
                    return redirect('/admin/filter/attributes-filter')
                        ->with(['success' => 'Успешно изменено']);
                } else {
                    return back()
                        ->withErrors(['msg' => "Ошибка изменения"])
                        ->withInput();
                }
            } else {
                if ($request->isMethod('get')) {

                    $atrr = $this->filterAttrsRepository->getInfoProduct($id);
                    $group = $this->filterGroupRepository->getAllGroupsFilter();
                    MetaTag::setTags(['title' => 'Редактирование фильтра']);
                    return view('shop.admin.filter.attrs-edit', compact('group','atrr'));
                }
            }
        }

    }
