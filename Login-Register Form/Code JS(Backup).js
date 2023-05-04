<script>
  document.addEventListener('DOMContentLoaded',function(){
    const regLink = document.querySelector('.login-form-pane .brxe-text-basic span.underline-link');
  	const logLink = document.querySelector('.register-form-pane .brxe-text-basic span.underline-link');
  	const logFormTabTitlesWrapper = document.querySelector('.tabtitle-wrapper');
  	const logFormTabTitles = document.querySelectorAll('.tabtitle-wrapper .tab-title');
  	const logFormTabContents = document.querySelectorAll('.tabcontent-wrapper .tab-pane');
  
  	regLink.addEventListener("click", function(){
			logFormTabTitles[0].classList.remove('brx-open');
			logFormTabContents[0].classList.remove('brx-open');
			logFormTabTitles[1].classList.add('brx-open');
			logFormTabTitlesWrapper.classList.add('tab-register');
			logFormTabContents[1].classList.add('brx-open');
	});
	logLink.addEventListener("click", function(){
			logFormTabTitles[1].classList.remove('brx-open');
			logFormTabContents[1].classList.remove('brx-open');
			logFormTabTitles[0].classList.add('brx-open');
			logFormTabTitlesWrapper.classList.remove('tab-register');
			logFormTabContents[0].classList.add('brx-open');
	});
 });   
</script>
