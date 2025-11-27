<div>
    <div class="col-md-12 p-0 mb-30">
        <div class="pd-20 card-box">
            <h5 class="h4 text-blue mb-20">Customtab Tab</h5>
            <div class="tab">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a wire:click="selectTab('setting_general')"
                            class="nav-link {{ $tab == 'setting_general' ? 'active' : '' }}" data-toggle="tab"
                            href="#setting_general" role="tab" aria-selected="true">General Setting</a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="selectTab('logo_favicon')"
                            class="nav-link {{ $tab == 'logo_favicon' ? 'active' : '' }}" data-toggle="tab"
                            href="#logo_favicon" role="tab" aria-selected="false">Logo Favicon</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'setting_general' ? 'active show' : '' }}" id="setting_general"
                        role="tabpanel">
                        <div class="pd-20">
                            <form wire:submit="GeneralSetting()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">site Title</label>
                                            <input type="text" class="form-control" wire:model="site_title">
                                            @error('site_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">site Email</label>
                                            <input type="text" class="form-control" wire:model="site_email">
                                            @error('site_email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">site Phone number <small>(optionnel)</small> </label>
                                            <input type="text" class="form-control" wire:model="site_phone_number">
                                            @error('site_phone_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">site Meta Keywords <small>(optionnel)</small> </label>
                                            <input type="text" class="form-control" wire:model="site_meta_keywords">
                                            @error('site_meta_keywords')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">site Description <small>(optionnel)</small> </label>
                                            <textarea type="text" class="form-control"
                                                wire:model="site_description"></textarea>
                                            @error('site_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Change</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'logo_favicon' ? 'active show' : '' }}" id="logo_favicon"
                        role="tabpanel">
                        <div class="pd-20">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>