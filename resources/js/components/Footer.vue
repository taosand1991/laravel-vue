<template>
  <section>
        <div class="social-icon">
            <div class="icon">
                <i class="fa fa-facebook"></i>
            </div>
            <div class="icon-text">
                <p>Facebook</p>
            </div>
        </div>
        <div class="social-icon">
            <div class="icon">
                <i class="fa fa-twitter"></i>
            </div>
            <div class="icon-text">
                <p>Twitter</p>
            </div>
        </div>
        <div class="social-icon">
            <div class="icon">
                <i class="fa fa-instagram"></i>
            </div>
            <div class="icon-text">
                <p>Instagram</p>
            </div>
        </div>
    </section>
</template>

<script>
export default {

}
</script>

<style scoped>
*{
    padding:0;
    margin:0;
}

section{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height: 10vh;
}

.social-icon{
    display:flex;
    width: 50px;
    height: 50px;
    cursor: pointer;
    border-radius: 50%;
    overflow: hidden;
    transition: all .3s linear;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    position: relative;
    background-color: blue;
    color: white;
    margin-left: 10px;
    box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.5);
}
.social-icon i{
    font-size:30px;
    font-weight: bolder;
}

.social-icon .icon-text{
    position: absolute;
    width: 100px;
    height: 30px;
    border-radius:10px;
    top: -55px;
    background-color: blue;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: 900;
    letter-spacing: 2px;
    box-shadow: 3px 3px 3px  rgba(0, 0, 0, 0.5);
}
 .social-icon .icon-text:after{
    content:'';
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    bottom: -10px;
    transform: translateX(40px) rotate(45deg);
    z-index: -5;
    text-align: center;
    left: 0;
    width:15%;
    height: 20px;
    background-color: blue;
}

.social-icon:nth-child(2) .icon-text{
    background-color: #00B8FF;
}
.social-icon:nth-child(3) .icon-text{
    background-color: #FF007B;
}

.social-icon:nth-child(2) .icon-text:after{
    background-color: #00B8FF;
}
.social-icon:nth-child(3) .icon-text:after{
    background-color: #FF007B;
}



.social-icon:nth-child(2){
    background-color:#00B8FF;
}

.social-icon:nth-child(3){
    background-color: #FF007B;
}

.social-icon:hover{
    overflow: visible;
    transform: translateY(-10px);
}

.social-icon:hover{
    background-color:white
}



.social-icon:nth-child(1):hover i{
    color:blue;
}
.social-icon:nth-child(2):hover i{
    color:#00B8FF;
}

.social-icon:nth-child(3):hover i{
    color:#FF007B;
}

</style>