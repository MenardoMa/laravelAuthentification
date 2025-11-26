@push('stylesheets')
    <style>
        button:disabled {
            cursor: not-allowed;
            opacity: .6;
        }
    </style>
@endpush
<div>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p">
                <div class="profile-photo">
                    <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i
                            class="fa fa-pencil"></i></a>
                    <img src="vendors/images/photo1.jpg" alt="" class="avatar-photo">
                </div>
                <h5 class="text-center h5 mb-0">{{ $name }}</h5>
                <p class="text-center text-muted font-14"> {{$email}} </p>
                <p class="text-center text-muted font-14"> {{$bio}} </p>
                <div class="profile-social">
                    <h5 class="mb-20 h5 text-blue">Social Links</h5>
                    <ul class="clearfix">
                        <li>
                            <a href="#" class="btn" data-bgcolor="#3b5998" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(59, 89, 152);"><i
                                    class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#1da1f2" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(29, 161, 242);"><i
                                    class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#007bb5" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(0, 123, 181);"><i
                                    class="fa fa-linkedin"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#f46f30" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(244, 111, 48);"><i
                                    class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#c32361" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(195, 35, 97);"><i
                                    class="fa fa-dribbble"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#3d464d" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(61, 70, 77);"><i
                                    class="fa fa-dropbox"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#db4437" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(219, 68, 55);"><i
                                    class="fa fa-google-plus"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#bd081c" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(189, 8, 28);"><i
                                    class="fa fa-pinterest-p"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#00aff0" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(0, 175, 240);"><i
                                    class="fa fa-skype"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#00b489" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(0, 180, 137);"><i
                                    class="fa fa-vine"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
                <div class="profile-tab height-100-p">
                    <div class="tab height-100-p">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item">
                                <a wire:click="selectTab('update_personnal')"
                                    class="nav-link {{ $tab == 'update_personnal' ? 'active' : '' }}" data-toggle="tab"
                                    href="#timeline" role="tab">Personnal
                                    Info</a>
                            </li>
                            <li class="nav-item">
                                <a wire:click="selectTab('update_password')"
                                    class="nav-link {{ $tab == 'update_password' ? 'active' : '' }}" data-toggle="tab"
                                    href="#tasks" role="tab">Password</a>
                            </li>
                            <li class="nav-item">
                                <a wire:click="selectTab('update_social')"
                                    class="nav-link {{ $tab == 'update_social' ? 'active' : '' }}" data-toggle="tab"
                                    href="#setting" role="tab">Social Link</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade {{ $tab == 'update_personnal' ? 'show active' : '' }}"
                                id="timeline" role="tabpanel">
                                <div class="pd-20">
                                    <form wire:submit="updatePersonnalDetail()">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Name</label>
                                                    <input type="text" class="form-control" placeholder="votre nom"
                                                        wire:model="name">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Username</label>
                                                    <input type="text" class="form-control" placeholder="votre username"
                                                        wire:model="username">
                                                    @error('username')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="text" disabled class="form-control"
                                                        placeholder="votre email" wire:model="email">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Bio</label>
                                                    <textarea type="text" class="form-control" placeholder="votre bio"
                                                        wire:model="bio"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">
                                                <span wire:loading.remove wire:target="updatePersonnalDetail">
                                                    Save changes
                                                </span>
                                                <span wire:loading wire:target="updatePersonnalDetail">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                    Traitement...
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade {{ $tab == 'update_password' ? 'show active' : '' }}" id="tasks"
                                role="tabpanel">
                                <div class="pd-20 profile-task-wrap">
                                    <div>
                                        <form wire:submit="updateUserPassword()">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Mot de Passe courant</label>
                                                        <input type="password" placeholder="Mot de passe courant"
                                                            class="form-control" wire:model="current_password">
                                                        @error('current_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Nouveau Mot de Passe</label>
                                                        <input type="password" placeholder="Nouveau Mot de Passe"
                                                            class="form-control" wire:model="new_password">
                                                        @error('new_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Confirmation </label>
                                                        <input type="password"
                                                            placeholder="Confirmation du nouveau Mot de Passe"
                                                            class="form-control" wire:model="new_password_config">
                                                        @error('new_password_config')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <span wire:loading.remove wire:target="updateUserPassword">Save
                                                        Change
                                                    </span>

                                                    <span wire:loading wire:target="updateUserPassword">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                        Traitement...
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade {{ $tab == 'update_social' ? 'show active' : '' }} " id="setting"
                                role="tabpanel">
                                <div class="pd-20 profile-task-wrap">
                                    <form wire:submit="updateSocialLink()">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Facebook</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="https://facebook.com/votre-profil"
                                                        wire:model="facebook">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">GitHub</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="https://github.com/votre-profil"
                                                        wire:model="github">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">LinkedIn</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="https://linkedin.com/in/votre-profil"
                                                        wire:model="linkedin">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Instagram</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="https://instagram.com/votre-profil"
                                                        wire:model="instagram">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Twitter</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="https://twitter.com/votre-profil"
                                                        wire:model="twitter">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Youtube</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="https://youtube.com/votre-profil"
                                                        wire:model="youtube">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <span wire:loading.remove wire:target="updateSocialLink()">Save
                                                change</span>
                                            <span wire:loading wire:target="updateSocialLink()">
                                                <i class="fa fa-spinner fa-spin"></i>
                                                Traitement...
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>