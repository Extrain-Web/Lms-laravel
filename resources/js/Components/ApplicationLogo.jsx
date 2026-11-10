export default function ApplicationLogo(props) {
    return (
        <img
            {...props}
            src="/images/logo.jpeg" // আপনার লোগোর সঠিক পাথ বা নাম এখানে দিন
            alt="Pure Sip"
            className="h-12 w-auto object-contain"
        />
    );
}