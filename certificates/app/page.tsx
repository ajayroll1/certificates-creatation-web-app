import Header from "./header/header"
import Footer from "./footer/footer"
import Hero from "./hero_section/hero"
import Carousel from "./carasol/carasol"
import Banner from "./banner/banner"
import Feedback from "./feedback_of_student/feedback"


export default function Home() {
  return (
    <div>
      <Header />
      <Hero />
      <Banner />
      <Carousel />
      <Feedback />
      <Footer />
    </div>
  
  );
}
